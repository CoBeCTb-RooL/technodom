<?
return [

    'db' =>[
        'username' => 'root',
        'password' => '',
        'host' => 'localhost',
        'dbName' => 'technodom',
    ],



    #   менеджеры основных сущностей
    'entityManagers'=>[
        'category' => 'App\\Lib\\MysqlCategoryManager',
//        'category' => 'App\\Lib\\HardcodeCategoryManager',    //  альтернативный агент категорий
        'product' => 'App\\Lib\\MysqlProductManager',
        'prop' => 'App\\Lib\\MysqlPropManager',
    ],


    #   валидатор
    'validators' => [
        'default' => 'App\\Lib\\SimpleValidator',
        'product'=>'',
    ],


];