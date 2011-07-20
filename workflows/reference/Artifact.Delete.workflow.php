<?php 
require_once(SBSERVICE);

/**
 *	@class ArtifactDeleteWorkflow
 *	@desc Removes artifact using ID
 *
 *	@param artid long int Artifact ID [memory]
 *	@param owner long int Owner ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class KeychainDeleteWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.delete.workflow',
			'input' => array('conn' => 'conn', 'artid' => 'artid', 'owner' => 'owner', 'admin' => 'admin'),
			'relation' => 'sbartifacts',
			'sqlcnd' => "where artid=\${artid} and (\${admin} or owner=\${owner});",
			'errormsg' => 'Invalid Artifact ID / Not Permitted'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>