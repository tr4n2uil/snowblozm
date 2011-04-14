<?php 
require_once('../../init.php');
require_once(SBINTERFACES);

require_once(dirname(__FILE__).'/GreetRequest.class.php');
require_once(dirname(__FILE__).'/GreetResponse.class.php');

class Greet implements Operation {
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
		return new GreetRequest();
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
		return new GreetResponse();
	}
}

?>