<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceMasterWorkflow
 *	@desc Manages editing of master key of existing reference 
 *
 *	@param keyid long int Usage Key ID [memory]
 *	@param id long int Reference ID [memory]
 *	@param level integer Web level [memory] optional default 0
 *	@param keyvalue string Key value [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceMasterWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('keyid', 'id', 'keyvalue'),
			'optional' => array('level' => 0)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Reference master key edited successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.chain.authorize.workflow',
			'input' => array('chainid' => 'id')
		),
		array(
			'service' => 'sb.chain.master.workflow',
			'input' => array('chainid' => 'id')
		),
		array(
			'service' => 'sb.key.edit.workflow',
			'input' => array('key' => 'keyvalue', 'keyid' => 'masterkey')
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