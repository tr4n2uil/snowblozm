<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceChildrenWorkflow
 *	@desc Manages children listing of existing reference 
 *
 *	@param keyid long int Usage Key ID [memory]
 *	@param id long int Reference ID [memory]
 *
 *	@return children array Chain children information [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceChildrenWorkflow implements Service {
	
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
		
		$memory['msg'] = 'Reference children listed successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.reference.authorize.workflow',
			'action' => 'list'
		),
		array(
			'service' => 'sb.web.children.workflow',
			'input' => array('parent' => 'id')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('children');
	}
	
}

?>