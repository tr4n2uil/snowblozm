<?php 
require_once(dirname(__FILE__).'/../snowblozm/interfaces.php');

require_once(dirname(__FILE__).'/adapter/Adapter.class.php');

// Concrete implementation for the Base service
class Base implements Service {
	
	public function getOperation($name){
		switch($name) {
			case 'adapter' :
				return new Adapter();
			default :
				// TODO : use exception handling
				return null;
		}
	}
}

?>
