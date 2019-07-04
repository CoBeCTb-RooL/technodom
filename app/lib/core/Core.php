<?php
namespace App\Lib;

class Core
{
    public function loadModels()
    {
        foreach(glob("app/models/*.php") as $file){
            require_once($file);
        }
        foreach(glob("app/models/*/*.php") as $file){
            require_once($file);
        }
    }


    public function loadLib()
    {
        foreach(glob("app/lib/*.php") as $file){
            require_once($file);
        }

        foreach(glob("app/lib/*/*.php") as $file){
            require_once($file);
        }

        foreach(glob("app/lib/*/*/*.php") as $file){
            require_once($file);
        }
        foreach(glob("app/lib/*/*/*/*.php") as $file){
            require_once($file);
        }



    }

}