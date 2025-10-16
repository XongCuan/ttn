<?php

namespace TCore\Base\Traits;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use TCore\Base\Supports\Helper;

trait LoadAndPublishData
{

    /**
     * Loads and registers the components for the current module.
     *
     * @param string|null $type The type of components to load. If null, defaults to 'TCore'.
     * @return $this
     */
    protected function loadComponents(string $type = null): self
    {
        if($type == null)
        {
            $type = 'TCore';
        }
        
        $type .= '\\' . ucfirst($this->getName());

        Blade::componentNamespace($type . '\\Views\\Components', $this->getUnderlineNamespace());

        return $this;
    }
    
    /**
     * Loads and registers the migrations for the current module.
     *
     * @return $this
     */
    protected function loadMigrations(): self
    {
        $paths = $this->getPath('database/migrations');
        
        $this->loadMigrationsFrom($paths);

        return $this;
    }

    protected function loadViews(): self
    {
        $viewPaths = $this->getPath('resources/views');
        
        $this->loadViewsFrom($viewPaths, $this->getUnderlineNamespace());

        return $this;
    }

    protected function loadLanguages(): self
    {
        $langPaths = $this->getPath('lang');
        
        $this->loadTranslationsFrom($langPaths, $this->getUnderlineNamespace());
        $this->loadJsonTranslationsFrom($langPaths);

        return $this;
    }

    protected function loadRoutes(): self
    {
        $routesPaths = $this->getFilesInFolder('routes');

        if(empty($routesPaths))
        {
            return $this;
        }

        Route::middleware('web')->group(function () use ($routesPaths) {

            foreach($routesPaths as $routePath)
            {
                $this->loadRoutesFrom($routePath);
            }    
        });

        return $this;
    }

    protected function loadConfig(array $exclude = []): self
    {
        $configPaths = $this->getFilesInFolder('config');
        
        foreach($configPaths as $configPath)
        {
            $fileName = pathinfo($configPath, PATHINFO_FILENAME);

            if(in_array($fileName, $exclude))
            {
                continue;
            }

            $this->mergeConfigFrom($configPath, $this->getUnderlineNamespace() .  '.' . $fileName);
        }

        return $this;
    }

    protected function loadHeplers(): self
    {
        Helper::autoload($this->getPath('helpers'));

        return $this;
    }

    protected function getPath(string $path = null): string
    {
        $reflection = new \ReflectionClass($this);
        $modulePath = strstr($reflection->getFileName(), '\src', true);

        if($modulePath == false)
        {
            $modulePath = strstr($reflection->getFileName(), '/src', true);
        }

        return $modulePath . ($path ? '/' . ltrim($path, '/') : '');
    }

    protected function getName(): string
    {
        return basename($this->getNamespace());
    }

    public function getNamespace(): string
    {
        return str_replace(base_path('platform'), '', $this->getPath());
    }

    public function getUnderlineNamespace(): string
    {
        return ltrim(str_replace(['/', '\\'], '_', $this->getNamespace()), "_");
    }

    protected function getFilesInFolder(string $folderName): array
    {
        $files = File::glob($this->getPath($folderName) . '/*.php');

        return $files;
    }
}