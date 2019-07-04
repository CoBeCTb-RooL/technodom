<?php
namespace App\Lib;


class PropManager extends BaseEntityManager implements IEntityManager {

    public function entityClass()
    {
        return 'App\\Models\\Prop';
    }
    public function agentClass()
    {
        return Config::val('entityManagers.prop');
    }


    public function get($id)
    {
        return parent::get($id);
    }
    public function getList($params=[])
    {
        return parent::getList($params);
    }


}