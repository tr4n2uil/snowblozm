<?php 
require_once(dirname(__FILE__).'/../../snowblozm/interfaces.php');

require_once(dirname(__FILE__).'/AdapterRequest.class.php');
require_once(dirname(__FILE__).'/AdapterContext.class.php');
require_once(dirname(__FILE__).'/AdapterTransform.class.php');
require_once(dirname(__FILE__).'/AdapterResponse.class.php');

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