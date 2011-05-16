<?php 

require_once(SBINTERFACES);

require_once('BaseAdapterRequest.class.php');
require_once('BaseAdapterContext.class.php');
require_once('BaseAdapterTransform.class.php');
require_once('BaseAdapterResponse.class.php');

class BaseAdapter implements Operation {

	// Operation interface
	public function getRequestService(){
		return new BaseAdapterRequest();
	}
	
	// Operation interface
	public function getContextService(){
		return new BaseAdapterContext();
	}
	
	// Operation interface
	public function getTransformService(){
		return new BaseAdapterTransform();
	}
	
	// Operation interface
	public function getResponseService(){
		return new BaseAdapterResponse();
	}
}

?>