<?php 
require_once(SBSERVICE);

/**
 *	@class RelationDeleteWorkflow
 *	@desc Executes DELETE query on relation
 *
 *	@param relation string Relation name [message]
 *	@param sqlcnd string SQL condition [message]
 *	@param params array Query parameters (with 'conn') [message] optional default input
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param errormsg string Error message [message] optional default 'Invalid Tuple'
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class RelationDeleteWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$relation = $message['relation'];
		$sqlcnd = $message['sqlcnd'];
		$params = isset($message['params']) ? $message['params'] : $message['input'];
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid Tuple';
		
		$mdl = array(
			'service' => 'sb.query.execute.workflow',
			'input' => $params,
			'query' => 'delete from '.$relation.' '.$sqlcnd.';',
			'rstype' => 1,
			'escparam' => $escparam,
			'errormsg' => $errormsg
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>