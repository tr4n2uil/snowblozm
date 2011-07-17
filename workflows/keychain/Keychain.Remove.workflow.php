<?php 
require_once(SBSERVICE);

/**
 *	@class KeychainRemoveWorkflow
 *	@desc Removes keychain member from keychain
 *
 *	@param keyid long int Key ID [memory]
 *	@param chainid long int Keychain ID [memory]
 *	@param owner long int Owner ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeychainRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.delete.workflow',
			'input' => array('conn' => 'conn', 'keyid' => 'keyid', 'chainid' => 'chainid', 'owner' => 'owner', 'admin' => 'admin'),
			'relation' => 'sb-members',
			'sqlcnd' => "where keyid=\${keyid} and chainid=(select chainid from sb-chains where chainid=\${chainid} and (\${admin} or owner=\${owner}));",
			'errormsg' => 'Invalid Keychain ID / Not Permitted'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>