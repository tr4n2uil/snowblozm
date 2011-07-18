<?php 
require_once(SBSERVICE);

/**
 *	@class KeyAvailableWorkflow
 *	@desc Checks for availability of service key value
 *
 *	@param keyvalue string Key value [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeyAvailableWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.unique.workflow',
			'input' => array('conn' => 'conn', 'keyvalue' => 'keyvalue'),
			'relation' => 'sbkeys',
			'sqlcnd' => "where keyvalue='\${keyvalue}';",
			'sqlprj' => 'owner',
			'escparam' => array('keyvalue' => 'keyvalue'),
			'not' => false,
			'errormsg' => 'Service key not available'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>