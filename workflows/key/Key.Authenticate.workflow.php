<?php 
require_once(SBSERVICE);

/**
 *	@class KeyAuthenticateWorkflow
 *	@desc Validates key/challenge and selects key ID
 *
 *	@param key string Usage key [memory] (service key md5 hashed with challenge)
 *	@param challenge string Challenge string [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
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
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'input' => array('conn' => 'conn', 'key' => 'key', 'challenge' => 'challenge'),
			'output' => array('result' => 'key'),
			'relation' => 'sbkeys',
			'sqlcnd' => "where MD5(concat(keyvalue, '\${challenge}'))='\${key}';",
			'sqlprj' => 'keyid',
			'escparam' => array('key' => 'key', 'challenge' => 'challenge'),
			'errormsg' => 'Invalid Service Key'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'input' => array('key' => 'key'),
			'output' => array('keyid' => 'keyid'),
			'params' => array('key.keyid' => 'keyid')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>