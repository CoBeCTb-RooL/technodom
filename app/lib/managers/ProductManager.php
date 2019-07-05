<?php
namespace App\Lib;


use App\Factories\ProductFactory;

class ProductManager extends BaseEntityManager implements IEntityManager {

    public function entityClass()
    {
        return 'App\\Models\\Product';
    }
    public function agentClass()
    {
        return Config::val('entityManagers.product');
    }



    #   переопределённые методы, т.к. механизм создания экземпляров необычный, юзаем фактори
    public function get($id, $withValues=true)
    {
        $ret = null;
        $agentClass = self::agentClass();
        $item = $agentClass::get($id);
        if($item)
            $ret = self::_createProductFromArray($item);

        if($withValues)
            self::initPropValues($ret);

        return $ret;
    }

    public function getList($params=[], $withValues=true)
    {
        $ret = null;
        $agentClass = self::agentClass();
        $list = $agentClass::getList($params);
        if(count($list))
            foreach ($list as $key=>$item)
            {
                $tmp = self::_createProductFromArray($item);
                if($withValues)
                    self::initPropValues($tmp);

                $ret[] = $tmp;
            }
        return $ret;
    }



    #   создаёт экземпляр по имени класса
    private static function _createProductFromArray($arr=[])
    {
        $className = ProductFactory::PRODUCT_TYPE_META[$arr['categoryId']]['className'];
        return Instanciator::getObj($className, $arr);
    }


    #   достаёт из базы значения свойств, и расфасовывает по полям
    public function initPropValues($obj)
    {
        self::setValuesFromArray( $obj, PropValuesManager::getValuesArray($obj->categoryId, $obj->id));
    }

    #   просто расфасовывает данные из массива по полям
    public static function setValuesFromArray($obj, $arr=[])
    {
        return Instanciator::initObj($obj, $arr);
    }





    public function save($obj)
    {
        $ret = true;

        $agentClass = self::agentClass();

        try{
            $ret = $agentClass::save($obj);
        }
        catch(\Exception $e)
        {
            DB::link()->rollback();
            $ret = $e->getMessage();
        }

        return $ret;
    }



    public function copyData($oFrom, $oTo)
    {
        $allFields = array_keys(get_class_vars(get_class($oFrom)));
        foreach ($allFields as $field)
            if(property_exists(get_class($oTo), $field))
                $oTo->$field = $oFrom->$field;
    }



    public function delete($obj)
    {
        $ret = true;
        if($obj)
        {
            $agentClass = self::agentClass();
            $ret = $agentClass::delete($obj);
        }

//        vd($ret);

        return $ret;
    }


}