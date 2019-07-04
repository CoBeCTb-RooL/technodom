<?php
namespace App\Lib;

class HardcodeCategoryManager{

    private static $_data = [
        ['id'=>1, 'title'=>'DVD (hardcode)', 'code'=>'dvd', ],
        ['id'=>2, 'title'=>'Книги (hardcode)', 'code'=>'books', ],
        ['id'=>3, 'title'=>'Мебель (hardcode)', 'code'=>'furniture', ],
    ];


    public function getList($params=[])
    {
        $ret = self::$_data;
        if(isset($params['id']))
        {
            $arr = [];
            foreach ($ret as $val)
                if($val['id'] == $params['id'])
                    $arr[] = $val;
            $ret = $arr;
        }

        return $ret;
    }


    public function get($id)
    {
        $ret = self::$_data;
        foreach ($ret as $val)
            if($val['id'] == $id)
                $ret = $val;
        return $ret;
    }


}
