<?php 
require_once(SBINTERFACES);

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
