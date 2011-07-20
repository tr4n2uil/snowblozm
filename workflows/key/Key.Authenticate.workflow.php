<?php 
require_once(SBSERVICE);

/**
 *	@class KeyAuthenticateWorkflow
 *	@desc Validates email keyvalue and selects key ID
 *
 *	@param email string Email [memory]
 *	@param key string Usage key [memory]
 *
 *	@return keyid long int Key ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeyAuthenticateWorkflow implements Service {
	
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
		
		$memory['msg'] = 'Key authenticated successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'args' => array('key', 'email'),
			'conn' => 'sbconn',
			'relation' => '`keys`',
			'sqlprj' => 'keyid',
			'sqlcnd' => "where `email`='\${email}' and `keyvalue`=MD5('\${email}\${key}')",
			'escparam' => array('key', 'email'),
			'errormsg' => 'Invalid Credentials'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'args' => array('result'),
			'params' => array('result.0.keyid' => 'keyid')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('keyid');
	}
	
}

?>