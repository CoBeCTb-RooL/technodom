<?php
namespace App\Lib;

class Config
{
    private static $_data;

    const SALT = '287q3c98!%%!_№7OBifo27tbrca7ot&*oiqw3b7*oBCBo&bo3BC';     //  соль для дефолтового значения
                                                                            //  если не передан второй парам в val()
                                                                            //  т.к. нужна возможность выставить значение null


    public function init()
    {
        self::$_data = require_once ('app/config.php');
    }


    #   если нужно заменить значение
    #   финт с заменой значения решил сделать просто,
    #   из спортивного интереса
    public function val($code, $newVal=self::SALT)     //  соль, которая врядли когда-либо попадётся
    {
        $keys = array_values(array_filter(explode('.', $code)));

        #   генерим строку с нужным элементом массива
        $arrayItemStr = 'self::$_data';
        foreach ($keys as $k)
            $arrayItemStr.="['".$k."']";

        if($newVal == self::SALT)   //  просто отдаём
            return eval('return '.$arrayItemStr.';');
        else    //  заменяем
            eval($arrayItemStr.' = $newVal; ');
    }


}