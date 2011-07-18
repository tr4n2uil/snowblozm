<?php 
require_once(SBSERVICE);

/**
 *	@class WebRemoveWorkflow
 *	@desc Removes web member using child and parent chain IDs
 *
 *	@param child long int Chain ID [memory]
 *	@param parent long int Chain ID [memory]
 *	@param masterkey long int Master Key ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class WebRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.delete.workflow',
			'input' => array('conn' => 'conn', 'child' => 'child', 'parent' => 'parent', 'masterkey' => 'masterkey', 'admin' => 'admin'),
			'relation' => 'sbwebs',
			'sqlcnd' => "where child=\${child} and parent=(select chainid from sbchains where chainid=\${parent} and (\${admin} or masterkey=\${masterkey}));",
			'errormsg' => 'Invalid Parent Chain ID / Not Permitted'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>