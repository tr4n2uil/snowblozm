<?php 
require_once(SBSERVICE);

/**
 *	@class ServicekeyEditWorkflow
 *	@desc Removes servicekey using ID
 *
 *	@param keyid long int Key ID [memory]
 *	@param keyvalue string Servicekey value [memory]
 *	@param owner long int Owner ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ServicekeyEditWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.delete.workflow',
			'input' => array('conn' => 'conn', 'keyid' => 'keyid', 'keyvalue' => 'keyvalue', 'owner' => 'owner', 'admin' => 'admin'),
			'relation' => 'servicekeys',
			'sqlcnd' => "where keyid=\${keyid} and (\${admin} or owner=\${owner});"
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>