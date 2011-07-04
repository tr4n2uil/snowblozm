<?php 

require_once(SBSERVICE);

/**
 *	@class RemoteWorkflow
 *	@desc Proxy worflow for executing remote workflows
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
 **/
class RemoteWorkflow implements Service {
	
	/** 
	 *	@fields
	**/
	private $url, $root, $key;
	
	/** 
	 *	@constructor
	**/
	public function __construct($uri, $root, $key){
		$this->uri = $uri;
		$this->root = $root;
		$this->key = $key;
	}
	
	/** 
	 *	@interface Service interface
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		list($root, $service, $operation, $type) = explode('.', $this->uri);
		$memory['key'] = $this->key;
		
		$workflow = array(
		array(
			'service' => 'sb.data.encode.service',
			'output' => array('result' => 'data'),
			'data' => $memory,
			'type' => $type
		),
		array(
			'service' => 'sb.curl.execute.service',
			'input' => array('data' => 'data'),
			'output' => array('response' => 'data'),
			'url' => $this->root.$this->uri,
			'plain' => true
		),
		array(
			'service' => 'sb.data.decode.service',
			'input' => array('data' => 'data'),
			'output' => array('result' => 'result'),
			'type' => $type
		));
		
		$memory = $kernel->execute($workflow, $memory);
		
		if(!$memory['valid'])
			return $memory;
		
		return $memory['result'];
	}
	
}

?>
