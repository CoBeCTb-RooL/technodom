<?php
namespace App\Models;

use App\Lib\CategoryManager;
use App\Lib\Config;
use App\Lib\PropManager;

class Product {
    public $id;
    public $title;
    public $sku;
    public $price;
    public $categoryId;

    private $_category;
    private $_props;


    public function validationMeta()
    {
        return [
            'title' => [
                'type' => 'text',
                'errorMsg'=>'Введите название!',
            ],
            'sku' => [
                'type' => 'text',
                'errorMsg'=>'Введите SKU!',
            ],
            'categoryId' => [
                'type' => 'int',
                'errorMsg'=>'Укажите категорию!',
            ],
            'price' => [
                'type' => 'float',
                'errorMsg'=>'Введите корректную цену!',
            ],
        ];
    }


    #   возвращает категорию
    public function category($cats=null)
    {
        $ret = $this->_category;
        if(!$ret)
        {
            $cats = $cats ?? CategoryManager::getList();
            if(count($cats))
                foreach ($cats as $item)
                    if($this->categoryId == $item->id)
                        $ret = $this->_category = $item;
        }

        return $ret;
    }

    #   насильно вписывает категорию в поле category
    public function initCategory($cats=null)
    {
        $this->category = $this->category($cats);
    }




    #   возвращает категорию
    public function props($props=null)
    {
        $ret = $this->_props;
        if(!$ret)
        {
            $props = $props ?? PropManager::getList(['categoryId'=>$this->categoryId, ]);
            if(count($props))
                foreach ($props as $item)
                    $ret[] = $item;
        }
        $this->_props = $ret;

        return $ret;
    }

    #   насильно вписывает категорию в поле category
    public function initProps($props=null)
    {
        $this->props = $this->props($props);
    }



    public function validate()
    {
        $validatorClass = Config::val('validators.product') ? Config::val('validators.product') : Config::val('validators.default');
        $validator = new $validatorClass($this, $this->validationMeta());
        return $validator->validate();
    }


}