<?php 
require_once(dirname(__FILE__).'/../../snowblozm/interfaces.php');

require_once(dirname(__FILE__).'/GreetRequest.class.php');
require_once(dirname(__FILE__).'/GreetContext.class.php');
require_once(dirname(__FILE__).'/GreetTransform.class.php');
require_once(dirname(__FILE__).'/GreetResponse.class.php');

class Greet implements Operation {

	// Operation interface
	public function getRequestService(){
		return new GreetRequest();
	}
	
	// Operation interface
	public function getContextService(){
		return new GreetContext();
	}
	
	// Operation interface
	public function getTransformService(){
		return new GreetTransform();
	}
	
	// Operation interface
	public function getResponseService(){
		return new GreetResponse();
	}
}

?>