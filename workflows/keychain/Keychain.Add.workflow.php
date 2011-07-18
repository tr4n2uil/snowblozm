<?php 
require_once(SBSERVICE);

/**
 *	@class KeychainAddWorkflow
 *	@desc Adds key to keychain
 *
 *	@param keyid long int Key ID [memory]
 *	@param chainid long int Keychain ID [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return return id long int Keychain member ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeychainAddWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.insert.workflow',
			'input' => array('conn' => 'conn', 'chainid' => 'chainid', 'keyid' => 'keyid'),
			'output' => array('id' => 'id'),
			'relation' => 'sbmembers',
			'sqlcnd' => "(chainid, keyid) values ('\${chainid}', \${keyid});"
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>