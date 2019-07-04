<?php
namespace App\Lib;

class MysqlCategoryManager extends MysqlBaseManager {

    public function tbl()
    {
        return 'categories';
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

        if(isset($params['id']) && intval($params['id']))
            $clauses[] = DBQueryHelper::whereEquals('id', $params['id']);


        return $clauses;
    }


}
