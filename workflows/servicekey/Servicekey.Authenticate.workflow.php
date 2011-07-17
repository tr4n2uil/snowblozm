<?php 
require_once(SBSERVICE);

/**
 *	@class ServicekeyAuthenticateWorkflow
 *	@desc Validates key/challenge and selects owner
 *
 *	@param key string Usage key [memory]
 *	@param challenge string Challenge string [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return owner long int Owner ID [memory]
 *	@return keyid long int Servicekey ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ServicekeyAuthenticateWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'input' => array('conn' => 'conn', 'key' => 'key', 'challenge' => 'challenge'),
			'output' => array('result' => 'key'),
			'relation' => 'servicekeys',
			'sqlcnd' => "where MD5(concat(keyvalue, '\${challenge}'))='\${key}';",
			'sqlprj' => 'owner',
			'escparam' => array('key' => 'key', 'challenge' => 'challenge'),
			'errormsg' => 'Invalid Service Key'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'input' => array('key' => 'key'),
			'output' => array('keyid' => 'keyid', 'owner' => 'owner'),
			'params' => array('key.keyid' => 'keyid', 'key.owner' => 'owner')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>