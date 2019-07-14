<?php
namespace App\Lib;


class Query {
    public $operation;
    public $columns;
    public $tbl;
    public $innerJoin;
    public $where;
    public $values;

    public function select($columns='*')
    {
        $this->operation = 'select';
        $this->columns = $columns;

        return $this;
    }

    public function update($arr=[], $isCleanValues=false)
    {
        $this->operation = 'update';

        $this->values($arr, $isCleanValues);

        return $this;
    }
    public function insert($arr=[], $isCleanValues=false)
    {
        $this->operation = 'insert';

        $this->values($arr, $isCleanValues);

        return $this;
    }
    public function delete()
    {
        $this->operation = 'delete';
        return $this;
    }

    public function tbl($tbl)
    {
        $this->tbl = $tbl;
        return $this;
    }


    public function where($column, $operator, $val='qwertyuiopqwertyuiopqwertyuiop')
    {
        if($val == 'qwertyuiopqwertyuiopqwertyuiop')
        {
            $val = $operator;
            $operator = '=';
        }
        $this->where[] = ['where', $column, $operator, $val];

        return $this;
    }


    public function whereIn($column, $arr, $isNotIn=false)
    {
        $this->where[] = ['whereIn', $column, $arr, $isNotIn];

        return $this;
    }

    public function whereNotIn($column, $arr)
    {
        return $this->whereIn($column, $arr, $isNotIn=true);
    }


    public function innerJoin($str)
    {
        $this->innerJoin[] = $str;
        return $this;
    }


    public function values($arr=[], $isCleanValues=false)
    {
        if(!$isCleanValues)
            $this->values = array_merge($this->values ?? [], $arr);
        else
            $this->values = $arr;
        return $this;
    }




    public function assemble()
    {
        $sql = '';
        if($this->operation == 'select')
            $sql .= "\nSELECT " . $this->columns . " FROM " . $this->tbl . " ";
        if($this->operation == 'update')
            $sql .= "\nUPDATE `" . $this->tbl . "` ";
        if($this->operation == 'insert')
            $sql .= "\nINSERT INTO `" . $this->tbl . "` ";
        if($this->operation == 'delete')
            $sql .= "\nDELETE FROM `" . $this->tbl . "` ";

        #   INNER JOIN
        if($this->innerJoin && count($this->innerJoin))
        {
            foreach ($this->innerJoin as $v)
            $sql.="\nINNER JOIN ".$v." ";
        }


        #   VALUES
        if($this->values && count($this->values))
        {
            $valuesStrings = [];
            foreach ($this->values as $key=>$val)
                $valuesStrings[] = self::makeKeyValueStr($key, $val);
            if(count($valuesStrings))
                $sql .= "\nSET\n".join(",\n", $valuesStrings);
        }


        #   WHERE and WHERE IN, WHERE NOT IN
        if($this->where && count($this->where))
        {
            $whereStrings = [];
            foreach ($this->where as $where)
            {
                $type = $where[0];
                if($type == 'where')
                    $whereStrings[] = "".DB::escapeString($where[1])."".DB::escapeString($where[2])."".self::valStr($where[3])."";
                if($type == 'whereIn')
                {
                    $vals = $where[2];
                    $escapedVals = [];
                    if(count($vals))
                        foreach ($vals as $val)
                            $escapedVals[] = self::valStr($val);
                    $whereStrings[] = "".DB::escapeString($where[1])." ".(!$where[3] ? "IN" : "NOT IN" )." (".join(", ", $escapedVals).")";
                }
            }
            if(count($whereStrings))
                $sql.="\nWHERE ".join(" \nAND ", $whereStrings);
        }





        return $sql;
    }




    public function makeKeyValueStr($key, $val)
    {
        $ret = "`".DB::escapeString($key)."` = ".self::valStr($val);
        return  $ret;
    }

    public function valStr($str)
    {
        $ret = DB::escapeString($str);
        if(!is_numeric($ret))
            $ret = "'".$ret."'";
        return $ret;
    }




}