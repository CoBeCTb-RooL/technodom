<?php
namespace App\Lib;

class ValidationProblem{
    public $msg;
    public $field;
    private $_errCode;

    public function __construct($msg, $field='', $errCode='')
    {
        $this->msg = $msg;
        $this->field = $field;
        $this->_errCode = $errCode;
    }

    public function errCode()
    {
        return $this->_errCode;
    }

}