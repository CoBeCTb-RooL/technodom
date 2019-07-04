<?php
namespace App\Lib;


class Instanciator{

    public function getObj($className, $arr=[])
    {
        $className = $className;
        $ret = new $className();

        return self::initObj($ret, $arr);
    }


    public function initObj($obj, $arr=[])
    {
        $ret = $obj;
        if($arr && count($arr))
            foreach ($arr as $prop => $val)
                if (property_exists(get_class($obj), $prop))
                    $ret->$prop = $val;
        return $ret;
    }

}