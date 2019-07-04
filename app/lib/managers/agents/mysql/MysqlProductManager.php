<?php
namespace App\Lib;

class MysqlProductManager extends MysqlBaseManager {

    public function tbl()
    {
        return 'products';
    }

    #   опционально, если нужно внести какие-то штуки
    public function getList($params=[])
    {
        $queryParams = $params;
//        $queryParams = [
//            'from' => 'aaaaa',
//            'clauses' => self::clauses($params),
//        ];

        return parent::getList($queryParams);
    }


    public function clauses($params=[])
    {

        if(isset($params['categoryId']) && intval($params['categoryId']))
            $clauses[] = DBQueryHelper::whereEquals('categoryId', $params['categoryId']);


        return $clauses;
    }


}
