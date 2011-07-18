<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceAddWorkflow
 *	@desc Manages addition of new reference 
 *
 *	@param key string Usage key [memory] (service key md5 hashed with challenge)
 *	@param challenge string Challenge string [memory]
 *	@param parent long int Reference ID [memory]
 *	@param level integer Collection level [message|memory] optional default 0
 *	@param chainname string Keychain name [memory]
 *	@param owner long int Owner ID [memory] optional default keyowner
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return return id long int Reference ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceAddWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$memory['level'] = isset($message['level']) ? $message['level'] : (isset($memory['level']) ? $memory['level'] : 0);
		$keyowner = isset($memory['owner']) ? 'keyowner' : 'owner';
		
		$workflow = array(
		array(
			'service' => 'sb.reference.authorize.workflow',
			'input' => array('conn' => 'conn', 'key' => 'key', 'challenge' => 'challenge', 'parent' => 'id', 'level' => 'level'),
			'output' => array('admin' => 'admin', 'owner' => $keyowner)
		),
		array(
			'service' => 'sb.keychain.create.workflow',
			'input' => array('conn' => 'conn', 'chainname' => 'chainname', 'owner' => 'owner'),
			'output' => array('id' => 'chainid')
		),
		array(
			'service' => 'sb.artifact.create.workflow',
			'input' => array('conn' => 'conn', 'chainid' => 'chainid', 'owner' => 'owner'),
			'output' => array('id' => 'id')
		),
		array(
			'service' => 'sb.artifact.add.workflow',
			'input' => array('conn' => 'conn', 'id' => 'child', 'parent' => 'parent'),
			'output' => array('id' => 'clmbrid')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>