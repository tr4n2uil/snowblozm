<?php 
require_once(SBSERVICE);

/**
 *	@class KeyIdentifyWorkflow
 *	@desc Identifies key from email and returns hash of it with challenge sent
 *
 *	@param email string Email [memory]
 *	@param challenge string Challenge to be used while hashing [memory] optional default 'snowblozm'
 *
 *	@return key string Key value hash [memory]
 *	@return keyid long int Key ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeyIdentifyWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('email'),
			'optional' => array('challenge' => 'snowblozm')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Key identified successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'args' => array('email', 'challenge'),
			'conn' => 'sbconn',
			'relation' => '`keys`',
			'sqlprj' => "keyid, MD5(concat(`keyvalue`,'\${challenge}')) as `key`",
			'sqlcnd' => "where `email`='\${email}'",
			'escparam' => array('email', 'challenge'),
			'errormsg' => 'Unable to identify key from email'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'args' => array('result'),
			'params' => array('result.0.keyid' => 'keyid', 'result.0.key' => 'key')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('keyid', 'key');
	}
	
}

?>