<?php

class indexController{

    public function index()
    {
        return view('index.index', ['aaa'=>1121, ]);
    }


    public function edit()
    {
        return view('index.edit');

    }


}