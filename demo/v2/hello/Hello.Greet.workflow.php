<?php 
require_once(SBSERVICE);

class HelloGreetWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$workflow = array(
		array(
			'service' => 'sb.request.read.service',
			'output' => array('name' => 'name'),
			'type' => $message['request-type']
		),
		array(
			'service' => 'sbdemo.hello.greet.service',
			'input' => array('name' => 'name'),
			'output' => array('view' => 'message')
		));
		
		$memory = $kernel->execute($workflow, $memory);

		$mdl = array(
			'service' => 'sb.response.write.service',
			'input' => array('message' => 'message'),
			'strict' => false,
			'type' => $message['response-type']
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>