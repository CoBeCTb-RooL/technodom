<?php
namespace App\Factories;


use App\Models\Product;

class ProductFactory{

    const TYPE_DVD = 1;
    const TYPE_BOOK = 2;
    const TYPE_FURNITURE = 3;


    const PRODUCT_TYPE_META = [
        self::TYPE_DVD => [
            'title' => 'DVD',
            'className' => 'App\\Models\\DVD',
        ],
        self::TYPE_BOOK => [
            'title' => 'Книга',
            'className' => 'App\\Models\\Book',
        ],
        self::TYPE_FURNITURE => [
            'title' => 'Мебель',
            'className' => 'App\\Models\\Furniture',
        ],
    ];


    public function create($productType=null)
    {
        $ret = null;

        if($productType)
        {
            $tmp = self::PRODUCT_TYPE_META[$productType]['className'];
            if($tmp)
            {
                $className = $tmp;
                return new $className();
            }
            else throw new \Exception('PRODUCT_TYPE_NOT_SUPPORTED ['.$productType.']');
        }
        else
            return new Product();

    }



}