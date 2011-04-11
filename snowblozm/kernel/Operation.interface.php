<?php

// Abstract interface for operations
interface Operation {

	// Get the request service
	public function getRequestService();
	
	// Get the context service
	public function getContextService();
	
	// Get the transform service
	public function getTransformService();
	
	// Get the response service
	public function getResponseService();
}

?>
