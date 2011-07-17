<?php 
require_once(SBSERVICE);

/**
 *	@class KeychainCreateWorkflow
 *	@desc Creates new keychain
 *
 *	@param chainname string Keychain name [memory]
 *	@param owner long int Owner ID [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return return id long int Keychain ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeychainCreateWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.insert.workflow',
			'input' => array('conn' => 'conn', 'chainname' => 'chainname', 'owner' => 'owner'),
			'output' => array('id' => 'id'),
			'relation' => 'sb-chains',
			'sqlcnd' => "(chainname, owner) values ('\${chainname}', \${owner});",
			'escparam' => array('chainname' => 'chainname')
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>