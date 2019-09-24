<?php
namespace Controllers;

class indexController{

    public function index()
    {
//        header('Location: /products');
        return view('admin.index.index', ['aaa'=>1121, ]);
    }


}