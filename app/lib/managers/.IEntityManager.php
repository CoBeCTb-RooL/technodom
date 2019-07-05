<?
namespace App\Lib;

interface IEntityManager{

    public function entityClass();
    public function agentClass();

    public function get($id);
    public function getList($params=[]);
    public function update($obj);
    public function delete($obj);
}