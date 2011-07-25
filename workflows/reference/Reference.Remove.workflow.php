<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceRemoveWorkflow
 *	@desc Manages removal of existing reference 
 *
 *	@param keyid long int Usage Key ID [memory]
 *	@param id long int Reference ID [memory]
 *	@param parent long int Reference ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('keyid', 'parent', 'id')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
	
		$memory['msg'] = 'Reference deleted successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.reference.authorize.workflow',
			'input' => array('chainid' => 'parent')
		),
		array(
			'service' => 'sb.chain.delete.workflow',
			'input' => array('chainid' => 'id')
		),
		array(
			'service' => 'sb.web.remove.workflow',
			'input' => array('child' => 'id')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array();
	}
	
}

?>