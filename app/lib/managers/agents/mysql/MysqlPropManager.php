<?php
namespace App\Lib;

class MysqlPropManager extends MysqlBaseManager {

    public function tbl()
    {
        return 'props';
    }


    public function clauses($params=[])
    {

        if(isset($params['categoryId']) && intval($params['categoryId']))
            $clauses[] = DBQueryHelper::whereEquals('categoryId', $params['categoryId']);


        return $clauses;
    }


}
