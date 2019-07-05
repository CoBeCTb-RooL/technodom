<?
namespace App;

use App\Lib\Core;
use App\Lib\State;

require_once('app/lib/core/Core.php');
Core::loadLib();


$state = new State();
$state->run();
