<?php 
require_once(SBSERVICE);

/**
 *	@class KeyEditWorkflow
 *	@desc Edits service key using ID
 *
 *	@param keyid long int Key ID [memory]
 *	@param key string Key value [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeyEditWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('key', 'keyid')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Key edited successfully';
		
		$service = array(
			'service' => 'sb.relation.update.workflow',
			'args' => array('key', 'keyid'),
			'conn' => 'sbconn',
			'relation' => '`keys`',
			'sqlcnd' => "set `keyvalue`=MD5(concat(`email`, '\${key}')) where `keyid`=\${keyid}",
			'escparam' => array('key'),
			'errormsg' => 'Invalid Key ID / No Change'
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