<?php 
require_once(SBSERVICE);

/**
 *	@class ChainDeleteWorkflow
 *	@desc Removes chain using ID
 *
 *	@param chainid long int Chain ID [memory]
 *	@param masterkey long int Key ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainDeleteWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('chainid', 'masterkey', 'admin')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Chain deleted successfully';
		
		$service = array(
			'service' => 'sb.relation.delete.workflow',
			'args' => array('chainid', 'masterkey', 'admin'),
			'conn' => 'sbconn',
			'relation' => '`chains`',
			'sqlcnd' => "where `chainid`=\${chainid} and (\${admin} or `masterkey`=\${masterkey})",
			'errormsg' => 'Invalid Chain ID / Not Permitted'
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