<?php
namespace App\Models;


use App\Lib\PropManager;

class Category {
    public $id;
    public $title;
    public $code;

    private $_props;


    public function props()
    {
        return $this->_props ? $this->_props : $this->_props = PropManager::getList(['categoryId'=>$this->id]);
    }



}