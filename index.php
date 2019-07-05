<?
namespace App;

use App\Lib\Core;
use App\Lib\State;

require_once('app/lib/core/Core.php');
require_once('app/lib/managers/agents/mysql/MysqlBaseManager.php');    //  видимость
require_once('app/lib/managers/IEntityManager.php');    //  видимость
Core::loadLib();


//throw new \Exception('123123');
$state = new State();
$state->run();
