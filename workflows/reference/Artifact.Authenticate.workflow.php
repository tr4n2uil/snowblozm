<?php 
require_once(SBSERVICE);

/**
 *	@class ArtifactAuthenticateWorkflow
 *	@desc Validates keyid to allow changes to artifact and sets admin flag if need be
 *
 *	@param artid long int Artifact ID [memory]
 *	@param keyid long int Key ID [memory]
 *	@param level integer Collection level [message|memory] optional default 0
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return admin integer Is admin [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ArtifactAuthenticateWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$level = isset($message['level']) ? $message['level'] : (isset($memory['level']) ? $memory['level'] : 0);
		
		$join = "chain in ";
		$chain = "(select chainid from sbmembers where keyid=\${keyid})";
		$child = "select child from sbcollections where parent in ";
		$query = $join.$chain;
		
		while($level--){
			$chain = '('.$child.$chain.')';
			$query = $query.' or '.$join.$chain;
		}
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'input' => array('conn' => 'conn', 'keyid' => 'keyid', 'artid' => 'artid'),
			'output' => array('result' => 'artifact'),
			'relation' => 'sbartifacts',
			'sqlcnd' => "where artid=\${artid} and ($query);",
			'sqlprj' => 'count(artid) as admin',
			'errormsg' => 'Invalid Service Key'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'input' => array('artifact' => 'artifact'),
			'output' => array('admin' => 'admin'),
			'params' => array('artifact.keyid' => 'admin')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>