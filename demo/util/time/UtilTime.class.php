<?php 

require_once(SBINTERFACES);
require_once(SBCOMLOADER);

require_once('UtilTimeTransform.class.php');
require_once('UtilTimeResponse.class.php');

class UtilTime implements Operation {
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
		return $this->adapter->getRequestService();
	}
	
	// Operation interface
	public function getContextService(){
		return $this->adapter->getContextService();
	}
	
	// Operation interface
	public function getTransformService(){
		return new UtilTimeTransform();
	}
	
	// Operation interface
	public function getResponseService(){
		return new UtilTimeResponse();
	}
}

?>