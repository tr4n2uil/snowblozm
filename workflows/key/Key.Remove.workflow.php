<?php 
require_once(SBSERVICE);

/**
 *	@class KeyRemoveWorkflow
 *	@desc Removes service key using ID
 *
 *	@param keyid long int Key ID [memory]
 *	@param keyvalue string Key value [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeyRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.delete.workflow',
			'input' => array('conn' => 'conn', 'keyid' => 'keyid'),
			'relation' => 'sbkeys',
			'sqlcnd' => "where keyid=\${keyid};",
			'errormsg' => 'Invalid Servicekey ID'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>