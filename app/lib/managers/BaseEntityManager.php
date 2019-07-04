<?php
namespace App\Lib;

class BaseEntityManager
{
    public function get($id)
    {
        $ret = null;
        $agentClass = static::agentClass();
        $item = $agentClass::get($id);
        if($item)
            return Instanciator::getObj(static::entityClass(), $item);
        return $ret;
    }


    public function getList($params=[])
    {
        $ret = null;
        $agentClass = static::agentClass();
        $list = $agentClass::getList($params);

        if(count($list))
            foreach ($list as $key=>$item)
                $ret[] = Instanciator::getObj(static::entityClass(), $item);


        return $ret;
    }



    public function update($obj)
    {}

    public function delete($obj)
    {}


}