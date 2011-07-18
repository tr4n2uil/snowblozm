<?php 
require_once(SBSERVICE);

/**
 *	@class ChainCreateWorkflow
 *	@desc Creates new chain
 *
 *	@param chainname string Keychain name [memory]
 *	@param masterkey long int Key ID [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return return id long int Chain ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainCreateWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.insert.workflow',
			'input' => array('conn' => 'conn', 'chainname' => 'chainname', 'masterkey' => 'masterkey'),
			'output' => array('id' => 'id'),
			'relation' => 'sbchains',
			'sqlcnd' => "(chainname, masterkey) values ('\${chainname}', \${masterkey});",
			'escparam' => array('chainname' => 'chainname')
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>