<?php 
require_once(SBSERVICE);

/**
 *	@class ServicekeyAvailableWorkflow
 *	@desc Checks for availability of servicekey value
 *
 *	@param keyvalue string Service key value [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ServicekeyAvailableWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.unique.workflow',
			'input' => array('conn' => 'conn', 'keyvalue' => 'keyvalue'),
			'relation' => 'servicekeys',
			'sqlcnd' => "where keyvalue='\${keyvalue}';",
			'sqlprj' => 'owner',
			'escparam' => array('keyvalue' => 'keyvalue'),
			'not' => false,
			'errormsg' => 'Servicekey not available'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>