<?php

class testController{

    public function index()
    {
//        echo 123;
//        return 1234;
        return new \App\Lib\State();
//        return [1, 456];
//        return  'products list products list products list products list products list products list  ';
    }


    public function edit()
    {
        return  'products edit products edit products edit products edit products edit ';
    }


}