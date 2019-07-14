<?php
namespace App\Lib;



class State{

    public $urlRaw;
    public $urlPath;
    public $urlParts;

    public $controller;
    public $action;

    public $content;
    public $layout;

    private static $_instance;  //  для статического доступа

    #   для удобства - в лэйауте помечать место, куда выведется контент
    const CONTENT_SIGN = 'P3VbbRQw=@bAaTvd_KQQDJRrK@WnSwz+-@+&6hwv*3RqFFX6xE';


    public function __construct()
    {
        $this->urlRaw = $_SERVER['REQUEST_URI'];
        $this->urlSection = explode('?', $this->urlRaw)[0];     //  без гет-параметров

        $this->urlSectionParts = array_values(array_filter(explode('/', $this->urlSection)));

        $this->controller = ($this->urlSectionParts[0] ?? 'index').'Controller';
        $this->action = ($this->urlSectionParts[1] ?? 'index');

        self::$_instance = &$this;  //  для статического доступа
    }



    function run()
    {
        #   здесь необходимо разрулить с роутами
        #   если удовлетворяющий роут не найден, то отработает по умолчанию - ПАРАМ1=контроллер, ПАРАМ2=экшн
        require_once('app/routes/app.php');
        if($route = Route::getRoute($this->urlRaw))
        {
            $this->controller = $route->controller;
            $this->action = $route->action;
        }
//        vd($route);

        $controllerPath = 'app/controllers/'.$this->controller.'.php';
        try{
            if(file_exists($controllerPath))
            {
                require_once ($controllerPath);
                if(method_exists($this->controller, $this->action))
                {
                    Config::init();     //  загружаем синглтон конфига
                    DB::connect();      //  загружаем синглтон конфига
                    Core::loadModels(); //  подгружаем модели (рекурсивно)
                    require_once ('app/startup/common.php');    //  общие процедуры

                    ob_start();
                    $contentResult = call_user_func($this->controller.'::'.$this->action);
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