<?php 

// Abstract interface for Context service
interface ContextService {

	// Generates the context from model
	public function getContext($model);
	
	// Writes back context
	public function setContext($context);
}

?>
