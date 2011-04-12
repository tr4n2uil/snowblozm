<?php 
require_once(dirname(__FILE__).'/../snowblozm/interfaces.php');

require_once(dirname(__FILE__).'/greet/Greet.class.php');

// Concrete implementation for the Hello service
class Hello implements Service {
	
	public function getOperation($name){
		switch($name) {
			case 'greet' :
				return new Greet();
			default :
				// TODO : use exception handling
				return null;
		}
	}
}

?>
