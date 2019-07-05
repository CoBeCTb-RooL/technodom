<?php
namespace App\Lib;

class Core
{
    public function loadModels()
    {
        $a = self::getDirContents('app/models');
        foreach ($a as $file)
            require_once($file);
    }


    public function loadLib()
    {
        $a = self::getDirContents('app/lib');
        foreach ($a as $file)
            require_once($file);
    }


    public function getDirContents($path)
    {
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        $files = array();
        foreach ($rii as $file)
            if (!$file->isDir())
                $files[] = $file->getPathname();

        return $files;
    }


}