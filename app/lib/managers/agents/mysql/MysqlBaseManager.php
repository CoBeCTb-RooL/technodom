<?php
namespace App\Lib;

class MysqlBaseManager {
    const PRIMARY_KEY = 'id';

    public function get($id)
    {
        $query = "SELECT * FROM `".DB::escapeString(static::tbl())."` WHERE ".DB::escapeString(static::PRIMARY_KEY)."='".DB::escapeString($id)."'";
        $res = DB::query($query);

        return $res->fetch_assoc();
    }


    public function getList($params=[])
    {
        $from = $params['from'] ?? static::tbl();
        $clauses = $params['clauses'] ?? static::clauses($params);

        $query = "SELECT * FROM `".DB::escapeString($from)."` WHERE 1 ".DBQueryHelper::joinClauses($clauses);
//        vd($query);
        $res = DB::query($query);
        while ($row = $res->fetch_assoc())
            $ret[] = $row;

        return $ret;
    }


    public function clauses($clauses=[]){}
    public function orderBy($clauses=[]){}


}
