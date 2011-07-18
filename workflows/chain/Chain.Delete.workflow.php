<?php 
require_once(SBSERVICE);

/**
 *	@class ChainDeleteWorkflow
 *	@desc Removes chain using ID
 *
 *	@param chainid long int Chain ID [memory]
 *	@param masterkey long int Key ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainDeleteWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.delete.workflow',
			'input' => array('conn' => 'conn', 'chainid' => 'chainid', 'masterkey' => 'masterkey', 'admin' => 'admin'),
			'relation' => 'sbchains',
			'sqlcnd' => "where chainid=\${chainid} and (\${admin} or masterkey=\${masterkey});",
			'errormsg' => 'Invalid Chain ID / Not Permitted'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>