<?php
namespace App\Lib;


class PropValuesManager  {


    #   переопределённые методы, т.к. механизм создания экземпляров необычный, юзаем фактори
    public function getValuesArray($catId, $id)
    {
        $query = "select * from `".DB::escapeString(self::tblNameByCatId($catId))."` WHERE productId=".intval($id);
        $res = DB::query($query);

        return $res->fetch_assoc();
    }


    public function tblNameByCatId($catId)
    {
        return 'propvalues__cat'.$catId;
    }




}