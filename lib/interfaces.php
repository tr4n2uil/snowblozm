<?php 

define( 'ROOT', dirname(__FILE__).'/');

require_once(ROOT . 'kernel/Component.interface.php');
require_once(ROOT . 'kernel/Operation.interface.php');
require_once(ROOT . 'kernel/Service.interface.php');

require_once(ROOT . 'service/RequestService.interface.php');
require_once(ROOT . 'service/ContextService.interface.php');
require_once(ROOT . 'service/TransformService.interface.php');
require_once(ROOT . 'service/ResponseService.interface.php');
require_once(ROOT . 'service/DataService.interface.php');

require_once(ROOT . 'loader/Loader.interface.php');

require_once(ROOT . 'parser/Parser.interface.php');


?>