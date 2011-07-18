<?php 
require_once(SBSERVICE);

/**
 *	@class KeyEditWorkflow
 *	@desc Edits service key using ID
 *
 *	@param keyid long int Key ID [memory]
 *	@param keyvalue string Key value [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeyEditWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.update.workflow',
			'input' => array('conn' => 'conn', 'keyid' => 'keyid', 'keyvalue' => 'keyvalue'),
			'relation' => 'sbkeys',
			'sqlcnd' => "set keyvalue='\${keyvalue}' where keyid=\${keyid};",
			'escparam' => array('keyvalue' => 'keyvalue'),
			'errormsg' => 'Invalid Service Key ID'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>