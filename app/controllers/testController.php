<?php
use App\Lib\Query;

class testController{

    public function index()
    {
        $q = new Query();
        $sql = $q->select('a.*, c.title')
                ->tbl('products a')
                ->innerJoin('categories c ON a.categoryId=c.id')
                ->where('a.id', 2)
                ->where('sku', '!=', "qsdfsdfwe")
                ->whereIn('a.id', [1, 2, 56, 112.3])
                ->whereNotIn('c.id', ['qwe3', 14])
                ->assemble();

        vd($sql);


        $q = new Query();
        $sql = $q->tbl('products')
            ->update(['title'=>'qweqwe', 'categoryId'=>131], $clean=true)
            ->values(['sku'=> 161113])
            ->where('id', 2)
            ->assemble();
        vd($sql);



        $q = new Query();
        $sql = $q->tbl('products')
            ->delete()
            ->where('id', 2)
            ->assemble();
        vd($sql);


        $q = new Query();
        $sql = $q->tbl('products')
            ->insert(['title'=>'qweqwe', 'categoryId'=>131], $clean=true)
            ->values(['sku'=> 161113])
            ->assemble();
        vd($sql);

dump($_SERVER);
//        vd($_SERVER);


//        vd($q);
    }


    public function json()
    {
        //        echo 123;
//        return 1234;
        return new \App\Lib\State();
//        return [1, 456];
//        return  'products list products list products list products list products list products list  ';
    }


}

