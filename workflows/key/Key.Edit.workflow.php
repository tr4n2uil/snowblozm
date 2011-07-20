<?php 
require_once(SBSERVICE);

/**
 *	@class KeyEditWorkflow
 *	@desc Edits service key using  email
 *
 *	@param email string Email [memory]
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
			'required' => array('key', 'email')
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
			'args' => array('key', 'email'),
			'conn' => 'sbconn',
			'relation' => '`keys`',
			'sqlcnd' => "set `keyvalue`=MD5('\${email}\${key}') where `email`='\${email}'",
			'escparam' => array('key', 'email'),
			'errormsg' => 'Invalid Email'
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