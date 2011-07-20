<?php 
require_once(SBSERVICE);

class HelloGreetWorkflow implements Service {
	
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
	public function run($memory){
		$kernel = new WorkflowKernel();

		$mdl = array(
			'service' => 'sbdemo.hello.greet.service',
			'input' => array('name' => 'name'),
			'output' => array('view' => 'message')
		);
		
		return $kernel->run($mdl, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('message');
	}
	
}

?>