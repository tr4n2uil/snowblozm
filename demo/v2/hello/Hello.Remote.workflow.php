<?php 
require_once(SBSERVICE);

class HelloRemoteWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'optional' => array('name' => 'SnowBlozm Workflows')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();

		$mdl = array(
			'service' => 'sbremote.hello.greet.service',
			'input' => array('name' => 'name'),
			'output' => array('message' => 'message')
		);
		
		return $kernel->run($mdl, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array(
			'required' => array('message')
		);
	}
	
}

?>