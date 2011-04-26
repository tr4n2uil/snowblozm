<?php 

// Abstract interface for operations
interface Component {

	// Get the context service
	public function getContextService();
	
	// Get the transform service
	public function getTransformService();
}

?>
