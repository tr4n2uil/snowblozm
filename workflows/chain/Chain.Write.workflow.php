<?php 
require_once(SBSERVICE);

/**
 *	@class ChainWriteWorkflow
 *	@desc Updates data for writing chain
 *
 *	@param chainid long int Chain ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainWriteWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('chainid')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Chain written successfully';
		
		$service = array(
			'service' => 'sb.relation.update.workflow',
			'args' => array('chainid'),
			'conn' => 'sbconn',
			'relation' => '`chains`',
			'sqlcnd' => "set `writes`=`writes`+1, `wtime`=now() where `chainid`=\${chainid}",
			'errormsg' => 'Invalid Chain ID'
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