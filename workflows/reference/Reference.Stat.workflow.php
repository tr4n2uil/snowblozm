<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceStatWorkflow
 *	@desc Returns statistics of reference
 *
 *	@param id long int Reference ID [memory]
 *
 *	@return stat array Statistics [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceStatWorkflow implements Service {
	
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
			'service' => 'sb.chain.stat.workflow',
			'input' => array('chainid' => 'id')
		);
		
		return $kernel->run($service, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('stat');
	}
	
}

?>