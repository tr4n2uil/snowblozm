<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceAddWorkflow
 *	@desc Manages addition of new reference 
 *
 *	@param keyid long int Usage Key ID [memory]
 *	@param parent long int Reference ID [memory]
 *	@param level integer Web level [memory] optional default 0
 *	@param owner long int Owner Key ID [memory] optional default keyid
 *
 *	@return return id long int Reference ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceAddWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('keyid', 'parent'),
			'optional' => array('level' => 0, 'owner' => false)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['owner'] = $memory['owner'] ? $memory['owner'] : $memory['keyid'];
		$memory['msg'] = 'Reference added successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.chain.authorize.workflow',
			'input' => array('chainid' => 'parent')
		),
		array(
			'service' => 'sb.chain.create.workflow',
			'input' => array('masterkey' => 'owner'),
			'output' => array('id' => 'chainid')
		),
		array(
			'service' => 'sb.web.add.workflow',
			'input' => array('child' => 'id')
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