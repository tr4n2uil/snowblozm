<?php 
require_once(SBSERVICE);

class HelloGreetWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$ml = new ModuleLoader();
		$kernel = new WorkflowKernel();
		$workflow = array();
		
		$mdl = array('service' => $ml->load('request.read.service', SBROOT));
		$mdl['params'] = array('name');
		$mdl['type'] = 'get';
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('hello.greet.service', SBROOT.'demo/'));
		array_push($workflow, $mdl);

		return $kernel->execute($workflow);
	}
	
}

?>