<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceAuthorizeWorkflow
 *	@desc Manages authorization of reference 
 *
 *	@param key string Usage key [memory] (service key md5 hashed with challenge)
 *	@param challenge string Challenge string [memory]
 *	@param id long int Reference ID [memory]
 *	@param level integer Collection level [message|memory] optional default 0
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return admin integer Is admin [memory]
 *	@return owner long int Owner ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceAuthorizeWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$memory['level'] = isset($message['level']) ? $message['level'] : (isset($memory['level']) ? $memory['level'] : 0);
		
		$workflow = array(
		array(
			'service' => 'sb.key.authenticate.workflow',
			'input' => array('conn' => 'conn', 'key' => 'key', 'challenge' => 'challenge'),
			'output' => array('keyid' => 'keyid', 'owner' => 'owner')
		),
		array(
			'service' => 'sb.artifact.authenticate.workflow',
			'input' => array('conn' => 'conn', 'id' => 'artid', 'keyid' => 'keyid', 'level' => 'level'),
			'output' => array('admin' => 'admin')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>