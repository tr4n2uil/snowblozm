<?php 
require_once(SBINTERFACES);

require_once('AdapterRequest.class.php');
require_once('AdapterContext.class.php');
require_once('AdapterTransform.class.php');
require_once('AdapterResponse.class.php');

class Adapter implements Operation {

	// Operation interface
	public function getRequestService(){
		return new AdapterRequest();
	}
	
	// Operation interface
	public function getContextService(){
		return new AdapterContext();
	}
	
	// Operation interface
	public function getTransformService(){
		return new AdapterTransform();
	}
	
	// Operation interface
	public function getResponseService(){
		return new AdapterResponse();
	}
}

?>