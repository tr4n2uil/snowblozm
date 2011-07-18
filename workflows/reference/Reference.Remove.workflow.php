<?php 
require_once(SBSERVICE);

/**
 *	@class ReferenceRemoveWorkflow
 *	@desc Manages removal of reference 
 *
 *	@param key string Usage key [memory] (service key md5 hashed with challenge)
 *	@param challenge string Challenge string [memory]
 *	@param id long int Reference ID [memory]
 *	@param parent long int Reference ID [memory]
 *	@param level integer Collection level [message|memory] optional default 0
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ReferenceRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$memory['level'] = isset($message['level']) ? $message['level'] : (isset($memory['level']) ? $memory['level'] : 0);
		
		$workflow = array(
		array(
			'service' => 'sb.reference.authorize.workflow',
			'input' => array('conn' => 'conn', 'key' => 'key', 'challenge' => 'challenge', 'parent' => 'id', 'level' => 'level'),
			'output' => array('admin' => 'admin', 'owner' => 'owner')
		),
		array(
			'service' => 'sb.artifact.info.workflow',
			'input' => array('conn' => 'conn', 'id' => 'artid'),
			'output' => array('chain' => 'chainid')
		),
		array(
			'service' => 'sb.keychain.delete.workflow',
			'input' => array('conn' => 'conn', 'chainid' => 'chainid', 'owner' => 'owner')
		),
		array(
			'service' => 'sb.artifact.delete.workflow',
			'input' => array('conn' => 'conn', 'id' => 'artid', 'owner' => 'owner', 'admin' => 'admin')
		),
		array(
			'service' => 'sb.artifact.remove.workflow',
			'input' => array('conn' => 'conn', 'id' => 'child', 'parent' => 'parent', 'keyid' => 'keyid', 'level' => 'level')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>