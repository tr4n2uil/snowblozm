<?php 
require_once(SBSERVICE);

/**
 *	@class ArtifactAddWorkflow
 *	@desc Adds artifact child to parent collection
 *
 *	@param child long int Artifact ID [memory]
 *	@param parent long int Artifact ID [memory]
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return return id long int Collection member ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ArtifactAddWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$mdl = array(
			'service' => 'sb.relation.insert.workflow',
			'input' => array('conn' => 'conn', 'child' => 'child', 'parent' => 'parent'),
			'output' => array('id' => 'id'),
			'relation' => 'sbcollections',
			'sqlcnd' => "(child, parent) values (\${child}, \${parent});"
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>