<?php 
require_once(dirname(__FILE__).'/../../snowblozm/interfaces.php');

class AdapterContext implements ContextService {

	// ContextService interface
	public function getContext($model){
		return array();
	}
	
	// ContextService interface
	public function setContext($context){
		
	}
}

?>
