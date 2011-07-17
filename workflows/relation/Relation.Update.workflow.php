<?php 
require_once(SBSERVICE);

/**
 *	@class RelationUpdateWorkflow
 *	@desc Executes UPDATE query on relation
 *
 *	@param relation string Relation name [message]
 *	@param sqlcnd string SQL condition [message]
 *	@param params array Query parameters (with 'conn') [message] optional default input
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param not boolean Value check nonequal [message] optional default true
 *	@param errormsg string Error message [message] optional default 'Invalid Tuple'
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class RelationUpdateWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$relation = $message['relation'];
		$sqlcnd = $message['sqlcnd'];
		$params = isset($message['params']) ? $message['params'] : $message['input'];
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$not = isset($message['not']) ? $message['not'] : true;
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid Tuple';
		
		$workflow = array(
		array(
			'service' => 'sb.query.execute.workflow',
			'input' => $params,
			'output' => array('sqlresult' => $relation),
			'query' => 'update '.$relation.' '.$sqlcnd.';',
			'rstype' => 1,
			'escparam' => $escparam,
			'not' => $not,
			'errormsg' => $errormsg
		),
		array(
			'service' => 'sbcore.data.select.service',
			'input' => array($relation => $relation),
			'output' => array($relation => $relation),
			'params' => array($relation.'.0' => 'tuple')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>