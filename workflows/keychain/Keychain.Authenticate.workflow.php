<?php 
require_once(SBSERVICE);

/**
 *	@class KeychainAuthenticateWorkflow
 *	@desc Authenticates membership of key ID in keychain and sets admin flag in memory
 *
 *	@param keyid long int Servicekey ID [memory]
 *	@param chainid long int Keychain ID [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return admin integer Is admin [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeychainAuthenticateWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'input' => array('conn' => 'conn', 'keyid' => 'keyid', 'chainid' => 'chainid'),
			'output' => array('result' => 'result'),
			'relation' => 'sb-members',
			'sqlcnd' => "where keyid=\${keyid} and chainid=\${chainid};",
			'sqlprj' => 'count(keyid) as admin'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'input' => array('result' => 'result'),
			'output' => array('admin' => 'admin'),
			'params' => array('result.admin' => 'admin')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>