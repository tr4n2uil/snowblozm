<?php

// Abstract interface for operations
interface Operation {

	// Get the request service
	public function getRequestService();
	
	// Get the response service
	public function getResponseService();
}

?>
