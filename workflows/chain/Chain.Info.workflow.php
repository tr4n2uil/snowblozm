<?php 
require_once(SBSERVICE);

/**
 *	@class ChainInfoWorkflow
 *	@desc Returns chain information
 *
 *	@param chainid long int Chain ID [memory]
 *
 *	@return masterkey long int Master key ID [memory]
 *	@return level integer Level [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainInfoWorkflow implements Service {
	
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
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'args' => array('chainid'),
			'conn' => 'sbconn',
			'relation' => '`chains`',
			'sqlprj' => '`masterkey`, `level`',
			'sqlcnd' => "where `chainid`=\${chainid}",
			'errormsg' => 'Invalid Chain ID'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'args' => array('result'),
			'params' => array('result.0.masterkey' => 'masterkey', 'result.0.level' => 'level')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('masterkey', 'level');
	}
	
}

?>