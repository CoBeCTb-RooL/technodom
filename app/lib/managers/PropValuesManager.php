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


    public function delete($catId, $prodId)
    {
        $query = "DELETE from `".DB::escapeString(self::tblNameByCatId($catId))."` WHERE productId=".intval($prodId);
        $res = DB::query($query);
        return $res;
    }


    public function insert($catId, $prodId, $fieldsArray)
    {
        if($fieldsArray && count($fieldsArray))
        {
            foreach ($fieldsArray as $field=>$val)
                $fieldsQueryStrings[] = "`".DB::escapeString($field)."` = '".DB::escapeString($val)."'";

            $query = "INSERT INTO `" . DB::escapeString(self::tblNameByCatId($catId)) . "` SET productId='".DB::escapeString($prodId)."', ".join(', ', $fieldsQueryStrings);
            $res = DB::query($query);
            if($res)    //  ОШИБКА
                throw new \Exception($res);
            echo $res;
        }
        return $res;
    }





}