<?php 
require_once(SBSERVICE);

/**
 *	@class KeychainDeleteWorkflow
 *	@desc Removes keychain using ID
 *
 *	@param chainid long int Keychain ID [memory]
 *	@param owner long int Owner ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeychainDeleteWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.delete.workflow',
			'input' => array('conn' => 'conn', 'chainid' => 'chainid', 'owner' => 'owner', 'admin' => 'admin'),
			'relation' => 'sbchains',
			'sqlcnd' => "where chainid=\${chainid} and (\${admin} or owner=\${owner});",
			'errormsg' => 'Invalid Keychain ID / Not Permitted'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>