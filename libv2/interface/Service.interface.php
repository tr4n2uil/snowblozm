<?php

/**
 *	@interface Service
 *	@desc Abstract interface for services and workflows (service compositions)
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
	
	/** 
	 *	@method input
	 *	@desc returns input array for the service
	 *
	 *	@return $input array ('required', 'optional')
	 *
	**/
	public function input();
	
	/** 
	 *	@method output
	 *	@desc returns output array for the service (other than default ('valid', 'msg', 'status', 'details'))
	 *
	 *	@return $output array
	 *
	**/
	public function output();
	
}
?>
