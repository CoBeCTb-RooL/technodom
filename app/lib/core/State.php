<?php
namespace App\Lib;



class State{

    public $urlRaw;
    public $urlPath;
    public $urlParts;

    public $subdir;
    public $controller;
    public $action;

    public $content;
    public $layout;

    private static $_instance;  //  для статического доступа

    #   для удобства - в лэйауте помечать место, куда выведется контент
    const CONTENT_SIGN = 'P3VbbRQw=@bAaTvd_KQQDJRrK@WnSwz+-@+&6hwv*3RqFFX6xE';


    public function __construct()
    {
        require_once('app/routes/app.php');

        $requestUri = $_SERVER['REQUEST_URI'];

        $this->urlRaw = $requestUri;
        $this->urlSection = explode('?', $this->urlRaw)[0];     //  без гет-параметров

        $urlSectionParts = array_values(array_filter(explode('/', $this->urlSection)));
        $this->urlSectionParts = $urlSectionParts;

        #   выясняем, не является ли первый урлсекшнПарт - группой сабдиров
        if($subdir = $this->getCurrentUrlGroup())
        {
            $this->subdir = $subdir;
            unset($urlSectionParts[0]);
            $urlSectionParts = array_values($urlSectionParts);
        }

        $this->controller = ($urlSectionParts[0] ?? 'index').'Controller';
        $this->action = ($urlSectionParts[1] ?? 'index');
        dump($this);

        self::$_instance = &$this;  //  для статического доступа
    }


    public function getCurrentUrlGroup()
    {
        foreach (Route::urlGroups() as $groupName)
            if($this->urlSectionParts[0] == $groupName)
                return $groupName;
    }



    function run()
    {
        #   здесь необходимо разрулить с роутами
        #   если удовлетворяющий роут не найден, то отработает по умолчанию - ПАРАМ1=контроллер, ПАРАМ2=экшн
        if($route = Route::getRoute($this->urlRaw))
        {
            $this->controller = $route->controller;
            $this->action = $route->action;
            $this->subdir = $route->subdir;
        }
//        dump($route);
//        dump($this);
//vd($this->controller);
        $controllerPath = 'app/controllers/'.($this->subdir ? $this->subdir.'/' : '').''.$this->controller.'.php';
//        vd($controllerPath);
        try{
            if(file_exists($controllerPath))
            {
//                vd($controllerPath);
                require_once ($controllerPath);
//                vd('Controllers\\'.$this->controller.'::'.$this->action);
                if(method_exists('Controllers\\'.$this->controller, $this->action))
                {
                    Config::init();     //  загружаем синглтон конфига
                    DB::connect();      //  загружаем синглтон конфига
                    Core::loadModels(); //  подгружаем модели (рекурсивно)
                    require_once ('app/startup/common.php');    //  общие процедуры

                    ob_start();
                    $contentResult = call_user_func('Controllers\\'.$this->controller.'::'.$this->action);
                    $this->content = $contentResult ?? ob_get_clean();

                    #   если лэйаут задан - стопудово будет строка, просто выводим её
                    if($this->layout)
                    {
                        if(file_exists($this->layoutPath))
                        {
                            ob_start();
                            require_once ($this->layoutPath);
                            $tmp = ob_get_clean();
                            echo str_replace(self::CONTENT_SIGN, $this->content, $tmp);
                        }
                        else throw new \Exception('Лэйаут <b>'.$this->layout.'</b> не существует!');
                    }
                    else
                    {
                        #   немножко проверка и приведение результата в жсон
                        switch(gettype($this->content))
                        {
                            case 'array':
                            case 'object':
                                header('Content-Type: application/json');
                                echo json_encode($this->content);
                                break;
                            default:
                                echo $this->content;
                                break;
                        }
                    }
                }
                else throw new \Exception('Метод <b>'.$this->controller.'::'.$this->action.'()</b> не существует!');
            }
            else throw new \Exception('Контроллер <b>'.$this->controller.'</b> не найден!');
        }
        catch (\Exception $e)
        {
            die(exception($e->getMessage()));
        }
    }



    public function view($str, $params=null)
    {
        ob_start();
        $path = 'app/views/'.join('/', explode('.', $str)).'.php';
        $MODEL = $params;   //  чтобы вся переданная модель была в 1 переменной во вью
        try{
            if(file_exists($path))
                require_once ($path);
            else throw new \Exception('Вью <b>'.$path.'</b> не существует!');
        }
        catch(\Exception $e){
            die(\exception($e->getMessage()));
        }

        return ob_get_clean();
    }



    public function layout($str)
    {
        self::$_instance->layout = $str;
        self::$_instance->layoutPath = 'app/views/layouts/'.$str.'.php';
    }


    #   для удобства - в лэйауте помечать место, куда выведется контент
    public static function content()
    {
        echo self::CONTENT_SIGN;
    }



}