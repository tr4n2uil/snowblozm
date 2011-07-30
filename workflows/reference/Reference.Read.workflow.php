<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceReadWorkflow
 *	@desc Tracks reads of reference
 *
 *	@param id long int Reference ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceReadWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('id')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$service = array(
			'service' => 'sb.chain.read.workflow',
			'input' => array('chainid' => 'id')
		);
		
		return $kernel->run($service, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array();
	}
	
}

?>