<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceParentsWorkflow
 *	@desc Manages parents listing of existing reference 
 *
 *	@param keyid long int Usage Key ID [memory]
 *	@param id long int Reference ID [memory]
 *
 *	@return parents array Chain parents information [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceParentsWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('keyid', 'id')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Reference parents listed successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.reference.authorize.workflow',
			'input' => array('chainid' => 'id')
		),
		array(
			'service' => 'sb.web.parents.workflow',
			'input' => array('child' => 'id')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('parents');
	}
	
}

?>