<?php 
require_once(SBSERVICE);

/**
 *	@class RelationInsertWorkflow
 *	@desc Executes INSERT query on relation
 *
 *	@param relation string Relation name [message]
 *	@param sqlcnd string SQL condition [message]
 *	@param params array Query parameters (with 'conn') [message] optional default input
 *	@param escparam array Escape parameters [message] optional default array()
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return return id long int Servicekey ID [memory] 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class RelationInsertWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$relation = $message['relation'];
		$sqlcnd = $message['sqlcnd'];
		$params = isset($message['params']) ? $message['params'] : $message['input'];
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		
		$mdl = array(
			'service' => 'sb.query.execute.workflow',
			'input' => $params,
			'output' => array('sqlresult' => 'id'),
			'query' => 'insert into '.$relation.' '.$sqlcnd.';',
			'rstype' => 2,
			'escparam' => $escparam
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>