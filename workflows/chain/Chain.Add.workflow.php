<?php 
require_once(SBSERVICE);

/**
 *	@class ChainAddWorkflow
 *	@desc Adds member key to Chain
 *
 *	@param keyid long int Key ID [memory]
 *	@param chainid long int Chain ID [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return return id long int Chain member key ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainAddWorkflow implements Service {
	
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