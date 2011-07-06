<?php 

require_once(SBINTERFACES);
require_once(SBCOMLOADER);

require_once('HelloGreetRequest.class.php');
require_once('HelloGreetResponse.class.php');

class HelloGreet implements Operation {
	protected 
		// adapter
		$adapter;

	// Constructor
	public function __construct(){
		$cl = new ComponentLoader();
		$this->adapter = $cl->load("base.adapter", SBROOT);
	}

	// Operation interface
	public function getRequestService(){
		return new HelloGreetRequest();
	}
	
	// Operation interface
	public function getContextService(){
		return $this->adapter->getContextService();
	}
	
	// Operation interface
	public function getTransformService(){
		return $this->adapter->getTransformService();
	}
	
	// Operation interface
	public function getResponseService(){
		return new HelloGreetResponse();
	}
}

?>