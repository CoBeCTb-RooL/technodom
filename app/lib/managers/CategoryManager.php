<?php
namespace App\Lib;


class CategoryManager extends BaseEntityManager implements IEntityManager {

    public function entityClass()
    {
        return 'App\\Models\\Category';
    }
    public function agentClass()
    {
        return Config::val('entityManagers.category');
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