<?php 
require_once(SBSERVICE);

/**
 *	@class ChainReadWorkflow
 *	@desc Updates data for reading chain
 *
 *	@param chainid long int Chain ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainReadWorkflow implements Service {
	
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
		
		$memory['msg'] = 'Chain read successfully';
		
		$service = array(
			'service' => 'sb.relation.update.workflow',
			'args' => array('chainid'),
			'conn' => 'sbconn',
			'relation' => '`chains`',
			'sqlcnd' => "set `reads`=`reads`+1, `rtime`=now() where `chainid`=\${chainid}",
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