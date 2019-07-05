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



    /*
     * @returns true, либо текст ошибки*/
    public function save($obj)
    {
        $ret = true;

        #   сперва базовые данные
        $objArray = (array)$obj;

        $baseFields = array_keys(get_class_vars(get_parent_class($obj)));
        $baseFields = array_filter($baseFields, function($v) {
            return $v != 'id' ;
        }, ARRAY_FILTER_USE_BOTH);

        $allFields = array_keys(get_class_vars(get_class($obj)));
        $allFields = array_filter($allFields, function($v) {
            return $v != 'id' ;
        }, ARRAY_FILTER_USE_BOTH);

        $baseFieldsQueryStrings = [];
        $propValues = [];

        #   генерим строки для инсерта, и собираем пропы
        foreach ($allFields as $field)
        {
            if(in_array($field, $baseFields))
                $baseFieldsQueryStrings[] = "`".DB::escapeString($field)."` = '".DB::escapeString($objArray[$field])."'";
            else
                $propValues[$field] = $objArray[$field];
        }

        #   начинаем сохранять
        DB::link()->begin_transaction();

        #   чистим инфу в свойствах
        if($obj->id)
        {
            #   придётся достать старый товар, чтобы узнать прошлый catId
            $oldProduct = ProductManager::get($obj->id, false);
            PropValuesManager::delete($oldProduct->categoryId, $obj->id );
        }

        #   сначала основной класс
        $sql = ($obj->id ? "UPDATE " : "INSERT INTO"). " `".DB::escapeString(static::tbl())."` SET ".join(', ', $baseFieldsQueryStrings) . ($obj->id ? " WHERE id=".DB::escapeString($obj->id) : "");
        DB::query($sql);


        #   записываем свойства
        PropValuesManager::insert($obj->categoryId, $obj->id ? $obj->id : DB::link()->insert_id, $propValues);
        DB::link()->commit();

        return $ret;
    }



    public function delete($obj)
    {
        $ret = true;
        try {
            DB::link()->begin_transaction();

            $query = "DELETE FROM `" . DB::escapeString(static::tbl()) . "` WHERE id=" . DB::escapeString($obj->id);
            DB::query($query);

            PropValuesManager::delete($obj->categoryId, $obj->id);
            DB::link()->commit();
        }
        catch(\Exception $e)
        {
            DB::link()->rollback();
            $ret = $e->getMessage();
        }

        return $ret;
    }


}
