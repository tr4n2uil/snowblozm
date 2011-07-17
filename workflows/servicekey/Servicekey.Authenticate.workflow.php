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
		
		$mdl = array(
			'service' => 'sb.relation.unique.workflow',
			'input' => array('conn' => 'conn', 'key' => 'key', 'challenge' => 'challenge'),
			'output' => array('result' => 'owner'),
			'relation' => 'servicekeys',
			'sqlcnd' => "where MD5(concat(keyvalue, '\${challenge}'))='\${key}';",
			'sqlprj' => 'owner',
			'attribute' => 'owner',
			'escparam' => array('key' => 'key', 'challenge' => 'challenge')
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>