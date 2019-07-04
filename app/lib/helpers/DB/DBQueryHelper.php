<?
namespace App\Lib;


class DBQueryHelper{


    public function whereEquals($column, $val)
    {
        return " AND ".self::equality($column, '=', $val);
    }


    public function equality($left, $equality, $right)
    {
        return DB::escapeString($left)." ".DB::escapeString($equality)." '".DB::escapeString($right)."'";
    }


    public function joinClauses($clauses=[])
    {
        $str = '';
        if(isset($clauses) && count($clauses))
            foreach ($clauses as $clause)
                $str.=" ".$clause;
        return $str;
    }



}