<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceGrantWorkflow
 *	@desc Manages granting of privileges to existing reference 
 *
 *	@param keyid long int Usage Key ID [memory]
 *	@param id long int Reference ID [memory]
 *	@param childkeyid long int Key ID to be granted [memory]
 *	@param level integer Web level [memory] optional default 0
 *
 *	@return return id long int Chain member ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceGrantWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('keyid', 'parent', 'childkeyid'),
			'optional' => array('level' => 0)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Reference privilege granted successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.chain.authorize.workflow',
			'input' => array('chainid' => 'id')
		),
		array(
			'service' => 'sb.chain.add.workflow',
			'input' => array('chainid' => 'id', 'keyid' => 'childkeyid')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('id');
	}
	
}

?>