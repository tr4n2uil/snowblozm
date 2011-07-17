<?php 
require_once(SBSERVICE);

/**
 *	@class RelationSelectWorkflow
 *	@desc Executes SELECT query on relation returning all results in resultset
 *
 *	@param relation string Relation name [message]
 *	@param sqlcnd string SQL condition [message]
 *	@param sqlprj string SQL projection [message] optional default *
 *	@param params array Query parameters (with 'conn') [message] optional default input
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param errormsg string Error message [message] optional default 'Error in Database'
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return relation array Resultset [memory] 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class RelationSelectWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$relation = $message['relation'];
		$sqlcnd = $message['sqlcnd'];
		$sqlprj = isset($message['sqlprj']) ? $message['sqlprj'] : '*';
		$params = isset($message['params']) ? $message['params'] : $message['input'];
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Error in Database';
		
		$mdl = array(
			'service' => 'sb.query.execute.workflow',
			'input' => $params,
			'output' => array('sqlresult' => $relation),
			'query' => 'select '.$sqlprj.' from '.$relation.' '.$sqlcnd.';',
			'escparam' => $escparam,
			'count' => 0,
			'not' => false,
			'errormsg' => $errormsg
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>