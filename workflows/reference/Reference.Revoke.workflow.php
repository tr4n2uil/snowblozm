<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceRevokeWorkflow
 *	@desc Manages revoking of privileges to existing reference 
 *
 *	@param keyid long int Usage Key ID [memory]
 *	@param id long int Reference ID [memory]
 *	@param childkeyid long int Key ID to be revoked [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceRevokeWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('keyid', 'id', 'childkeyid')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Reference privilege revoked successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.reference.authorize.workflow',
			'input' => array('chainid' => 'id'),
			'action' => 'edit'
		),
		array(
			'service' => 'sb.chain.remove.workflow',
			'input' => array('chainid' => 'id', 'keyid' => 'childkeyid')
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