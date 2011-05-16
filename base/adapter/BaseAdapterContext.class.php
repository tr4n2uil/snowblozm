<?php 

require_once(SBINTERFACES);

class BaseAdapterContext implements ContextService {

	// ContextService interface
	public function getContext($model){
		return $model;
	}
	
	// ContextService interface
	public function setContext($model){
		
	}
}

?>
