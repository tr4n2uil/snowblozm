<?php 
require_once(SBSERVICE);

/**
 *	@class ChainStatWorkflow
 *	@desc Returns chain statistics
 *
 *	@param chainid long int Chain ID [memory]
 *
 *	@return stat array Statistics information [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainStatWorkflow implements Service {
	
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
		
		$memory['msg'] = 'Chain information returned successfully';
		
		$service = array(
			'service' => 'sb.relation.unique.workflow',
			'args' => array('chainid'),
			'conn' => 'sbconn',
			'relation' => '`chains`',
			'sqlprj' => '`links`, `reads`, `writes`, `ctime`, `rtime`, `wtime`',
			'sqlcnd' => "where `chainid`=\${chainid}",
			'errormsg' => 'Invalid Chain ID',
			'output' => array('result' => 'stat')
		);
		
		return $kernel->run($service, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('stat');
	}
	
}

?>