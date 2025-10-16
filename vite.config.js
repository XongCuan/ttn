import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { readdirSync, existsSync } from 'fs';
import { resolve, relative } from 'path';
import { fileURLToPath, pathToFileURL } from 'url';

function toRelative(mainDirPath, subDir, filePath) {
    const absolutePath = resolve(mainDirPath, subDir, filePath);
    return relative(__dirname, absolutePath).replace(/\\/g, '/'); // Chuyển sang đường dẫn dạng POSIX
}

async function getAllPaths()
{

    const domainPath = resolve(__dirname, 'platform');

    const allPaths = [
        'resources/js/app.js',
        'resources/css/app.css',
    ];
    
    const mainDirs = ['core', 'packages', 'themes'];

    

    for (const mainDir of mainDirs)
    {
        const mainDirPath = resolve(domainPath, mainDir);

        const subDirs = readdirSync(mainDirPath, { withFileTypes: true })
            .filter(dirent => dirent.isDirectory()) // Chỉ lấy các thư mục
            .map(dirent => dirent.name);
        
        if (subDirs.length == 0)
        {
            continue;
        }
        

        for (const subDir of subDirs)
        {
            const configPath = resolve(mainDirPath, subDir, 'vite.config.js');
            
            try {

                if(existsSync(configPath))
                {
                    // Sử dụng import() để lấy cấu hình module
                    // const viteConfig = await import(configPath); // on mac
                    const viteConfig = await import(pathToFileURL(configPath).href); // on window
                    
                    // Kiểm tra nếu export const paths tồn tại và là một mảng
                    if (viteConfig.paths && Array.isArray(viteConfig.paths))
                    {
                        // Thêm 'platform/' vào đầu mỗi phần tử của paths
                        // const updatedPaths = viteConfig.paths.map(path => resolve(mainDirPath, subDir, path).replace(__dirname + '/', ''));
                        // const updatedPaths = viteConfig.paths.map(path => pathToFileURL(resolve(mainDirPath, subDir, path).replace(__dirname + '/', '')).href);
                        const updatedPaths = viteConfig.paths.map(path => toRelative(mainDirPath, subDir, path));

                        allPaths.push(...updatedPaths); // Hợp nhất các đường dẫn
                    }
                }
                
            } catch (error) {
                console.error(`Không thể tải cấu hình cho module ${module}:`, error);
            }
        }
    }
    
    return allPaths;
}

async function getConfig() {
    const paths = await getAllPaths();
    return defineConfig({
        plugins: [
            laravel({
                input: paths,
                refresh: true,
            }),
        ],
        css: {
            postcss: {
                plugins: [],
            },
        },
        assetsInclude: ['**/*.jpg', '**/*.png', '**/*.svg', '**/*.gif'],
        build: {
            minify: false,
            assetsInlineLimit: 0, // Ngăn chặn nhúng asset dưới dạng base64
            terserOptions: {
                mangle: false, // Tắt việc đổi tên biến/hàm
                compress: {
                  unused: false, // Không loại bỏ các biến/hàm không sử dụng
                  dead_code: false, // Không loại bỏ mã "chết"
                },
            },
            rollupOptions: {
                treeshake: false, // Tắt tree-shaking
                // assetFileNames: 'assets/[name].[ext]', // Giữ tên file gốc
                // preserveEntrySignatures: 'strict', // Giữ nguyên các đoạn mã không đổi
                output: {
                    // Đảm bảo hình ảnh không bị đổi tên hash và lưu trong thư mục build/assets
                    assetFileNames: (assetInfo) => {
                        if (assetInfo.name.endsWith('.png') || assetInfo.name.endsWith('.jpg')) {
                            return 'images/[name][extname]'; // Lưu hình ảnh vào thư mục images
                        }

                        return 'assets/[name][extname]';
                    }
                }
            }
        }
    });
}

export default getConfig();
