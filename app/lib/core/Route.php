<?php
namespace App\Lib;


class Route{

    public $mask;
    public $routeStr;
    public $controller;
    public $action;
    public $subdir;

    private static $_instances;


    public function __construct($mask, $action)
    {
        $this->routeStr = $action;
        $this->mask = $mask;
        $tmp = explode('@', $action);
        $this->controller = $tmp[0];
        $this->action = $tmp[1];

        #  разбираемся с поддиректорией контроллеров
//        vd($this->controller);
        if($pos = mb_strrpos($this->controller, '/'))
        {
            $ctrl = mb_substr($this->controller, $pos+1);
            $subdir = mb_substr($this->controller, 0, $pos);
//            vd($subdir);
            $this->controller = $ctrl;
            $this->subdir = $subdir;
        }
//        vd($this);
//        echo '<hr>';
    }


    public function create($mask, $action)
    {
        $a = new self($mask, $action);

        self::$_instances[] = $a;
        return $a;
    }



    public function getRoute($url)
    {
        foreach (Route::instances() as $r)
        {
            $url .='/';     #   чтобы не находились более короткие маски в массиве роутов, стоящие раньше
                            #   типа /editForm и /editFormSubmit

            $mask = $r->mask;
            if(!startsWith('/', $mask))
                $mask = '/'.$mask;
            if(!endsWith('/', $mask))
                $mask = $mask.'/';

            $mask = str_replace('/', '\/', $mask);
            $mask = '/('.$mask.')/';

//            vd($mask);
            $mask = str_replace('{int}', '([0-9]+.*)', $mask);
//            vd($mask);

            $matches = [];
            preg_match($mask, $url, $matches);
//            vd($matches);

            if($matches!=null && count($matches))
            {
                global $state;
                $state->params[0] = intval($matches[2]);
                return $r;
            }
        }
    }





    public function instances()
    {
        return self::$_instances;
    }



    public function subdir($dir)
    {
        //vd($dir);
    }

}