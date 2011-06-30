<?php

/**
 *	@interface Service
 *	@desc Abstract interface for services
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
interface Service {

	/** 
	 *	@method run
	 *	@desc executes the service functionality
	 *
	 *	@param $message object Configuration parameters
	 *	@param $memory object State management in workflows
	 *
	 *	@return $memory	object Current state in workflow
	 *
	**/
	public function run($message, $memory);
}
?>
