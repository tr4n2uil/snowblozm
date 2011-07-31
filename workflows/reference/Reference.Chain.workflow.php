<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceChainWorkflow
 *	@desc Manages chain member listing of existing reference 
 *
 *	@param keyid long int Usage Key ID [memory]
 *	@param id long int Reference ID [memory]
 *
 *	@return chain array Chain member information [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceChainWorkflow implements Service {
	
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
		
		$memory['msg'] = 'Reference member keys listed successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.reference.authorize.workflow',
			'input' => array('chainid' => 'id'),
			'action' => 'edit'
		),
		array(
			'service' => 'sb.chain.member.workflow',
			'input' => array('chainid' => 'id'),
			'output' => array('result' => 'chain')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('chain');
	}
	
}

?>