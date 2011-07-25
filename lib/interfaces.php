<?php 

define( 'ROOT', dirname(__FILE__).'/');

require_once(ROOT . 'interface/Component.interface.php');
require_once(ROOT . 'interface/Operation.interface.php');
//require_once(ROOT . 'interface/Service.interface.php');

require_once(ROOT . 'interface/RequestService.interface.php');
require_once(ROOT . 'interface/ContextService.interface.php');
require_once(ROOT . 'interface/TransformService.interface.php');
require_once(ROOT . 'interface/ResponseService.interface.php');
require_once(ROOT . '../libv2/interface/DataService.interface.php');

require_once(ROOT . 'interface/Loader.interface.php');


?>