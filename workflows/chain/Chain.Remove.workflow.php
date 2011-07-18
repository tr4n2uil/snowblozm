<?php 
require_once(SBSERVICE);

/**
 *	@class ChainRemoveWorkflow
 *	@desc Removes member key from chain
 *
 *	@param keyid long int Key ID [memory]
 *	@param chainid long int Chain ID [memory]
 *	@param masterkey long int Master Key ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.delete.workflow',
			'input' => array('conn' => 'conn', 'keyid' => 'keyid', 'chainid' => 'chainid', 'masterkey' => 'masterkey', 'admin' => 'admin'),
			'relation' => 'sbmembers',
			'sqlcnd' => "where keyid=\${keyid} and chainid=(select chainid from sbchains where chainid=\${chainid} and (\${admin} or masterkey=\${masterkey}));",
			'errormsg' => 'Invalid Chain ID / Not Permitted'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>