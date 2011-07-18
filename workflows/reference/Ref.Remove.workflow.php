<?php 
require_once(SBSERVICE);

/**
 *	@class ArtifactRemoveWorkflow
 *	@desc Removes collection member from child and parent IDs
 *
 *	@param child long int Artifact ID [memory]
 *	@param parent long int Artifact ID [memory]
 *	@param owner long int Owner ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ArtifactRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.delete.workflow',
			'input' => array('conn' => 'conn', 'child' => 'child', 'parent' => 'parent', 'owner' => 'owner', 'admin' => 'admin'),
			'relation' => 'sbcollections',
			'sqlcnd' => "where child=\${child} and parent=(select artid from sbartifacts where artid=\${parent} and (\${admin} or owner=\${owner}));",
			'errormsg' => 'Invalid Artifact ID / Not Permitted'
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>