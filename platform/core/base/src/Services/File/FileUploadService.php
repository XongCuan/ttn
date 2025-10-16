<?php
namespace TCore\Base\Services\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    private $disk = 'uploads';

    private $folder = '/';

    private $folderPrefix = 'public/uploads/';
    
    private $file;

    private $instance;

    private $status = true;

    public function setDisk($disk)
    {
        $this->disk = $disk;
        return $this;
    }

    public function setFolder($folder)
    {
        $this->folder = Str::finish($folder, '/');
        return $this;
    }

    public function setFolderPrefix($folderPrefix)
    {
        $this->folderPrefix = Str::finish($folderPrefix, '/');
        return $this;
    }
    
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function upload()
    {
        $path = $this->file->storeAs($this->folder, $this->file->hashName(), $this->disk);
        $this->instance = $this->folderPrefix . $path;
        return $this;
    }

    public function uploadMultipleFilepondEncode(array $files)
    {
        $pathFiles = [];
        
        foreach($files as $file)
        {
            if($file)
            {
                $this->file = $file;
            
                $this->uploadFilepondEncode();
    
                $pathFiles[] = $this->getInstance();
            }
        }

        $this->instance = $pathFiles;
        return $this;
    }

    public function uploadFilepondEncode()
    {
        $file = json_decode($this->file, true);

        return $this->uploadFileBase64($file);
    }

    public function uploadCheckFilepondEncode($fileExists)
    {
        $file = json_decode($this->file, true);

        if(array_key_exists($file['id'], $fileExists))
        {
            $this->instance = Str::after($fileExists[$file['id']], url('/'));
            return $this;
        }
        return $this->uploadFileBase64($file);
        
    }

    private function uploadFileBase64($file)
    {
        $fileContent = base64_decode($file['data']);

        if(Storage::disk($this->disk)->exists($this->folder . $file['name']))
        {
            $pathFile = $this->folder . $file['name'];
        }else {
            $pathFile = $this->folder . pathinfo($file['name'], PATHINFO_FILENAME) . '-' . uniqid_real(5) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

            Storage::disk($this->disk)->put($pathFile, $fileContent);
        }

        $this->instance = $this->folderPrefix . $pathFile;

        return $this;
    }

    public function move($pathFile, $newPath)
    {
        $newPath = $newPath.basename($pathFile);

        Storage::disk($this->disk)->move($pathFile, $newPath.basename($pathFile));

        $this->instance = $newPath;
        return $this;
    }

    public function delete($pathFile)
    {
        if($pathFile != null && $pathFile != '' )
        {
            Storage::disk($this->disk)->delete(Str::after($pathFile, $this->folderPrefix));
        }

        return $this;
    }
    
    public function deleteSimpleFiles(array $files)
    {

        $files = array_map(function($value){
            $value = Str::after(Str::after($value, url('/')), 'public/uploads/');
            return $value;

        }, $files);

        $files = array_filter($files, function($value){
            return !Str::startsWith($value, 'files/');
        });

        Storage::disk($this->disk)->delete(array_values($files));
        return $this;
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function getStatus()
    {
        return $this->status;
    }
}