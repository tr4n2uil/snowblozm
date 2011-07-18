<?php 
require_once(SBSERVICE);

/**
 *	@class ArtifactCreateWorkflow
 *	@desc Creates new artifact
 *
 *	@param chainid string Chain ID [memory]
 *	@param owner long int Owner ID [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return return id long int Artifact ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ArtifactCreateWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.insert.workflow',
			'input' => array('conn' => 'conn', 'chainid' => 'chainid', 'owner' => 'owner'),
			'output' => array('id' => 'id'),
			'relation' => 'sbartifacts',
			'sqlcnd' => "(chainid, owner) values (\${chainid}, \${owner});"
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>