<?php 
require_once(SBSERVICE);

/**
 *	@class KeyAddWorkflow
 *	@desc Adds new service key
 *
 *	@param keyvalue string Key value [memory]
 *	@param owner long int Owner ID [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return return id long int Key ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeyAddWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.insert.workflow',
			'input' => array('conn' => 'conn', 'keyvalue' => 'keyvalue', 'owner' => 'owner'),
			'output' => array('id' => 'id'),
			'relation' => 'sb-keys',
			'sqlcnd' => "(keyvalue, owner) values ('\${keyvalue}', \${owner});",
			'escparam' => array('keyvalue' => 'keyvalue')
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>