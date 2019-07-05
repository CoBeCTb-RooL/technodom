<?php
namespace App\Lib;


class SimpleValidator implements IValidator {

    public $obj;
    public $validationMeta;

    public function __construct($obj, $validationMeta)
    {
        $this->obj = $obj;
        $this->validationMeta = $validationMeta;
    }


    public function validate()
    {
        $ret = true;
        $problems = [];
        if($this->validationMeta && count($this->validationMeta))
            foreach ($this->validationMeta as $field=>$meta)
                if(!self::validateField($this->obj->$field, $meta['type']))
                    $problems[] = new ValidationProblem($meta['errorMsg'], $field);

        if(count($problems))
            $ret = $problems;

        return $ret;
    }



    public function validateField($val, $type)
    {
        $ret = false;

//        vd($val);
//        vd($type);
        switch($type)
        {
            case 'int':
                $ret = filter_var($val, FILTER_VALIDATE_INT)!==false;
                break;
            case 'float':
                $ret = filter_var($val, FILTER_VALIDATE_FLOAT)!==false;
                break;
            default:
                $ret = trim($val) ? true : false;
                break;
        }
//        vd($ret);
//        echo "\n-----------------------------------------\n";

        return $ret;
    }

}