<?php 
require_once(SBSERVICE);

/**
 *	@class RelationUniqueWorkflow
 *	@desc Executes SELECT query on relation returning unique result, if any, in resultset
 *
 *	@param relation string Relation name [message]
 *	@param sqlcnd string SQL condition [message]
 *	@param sqlprj string SQL projection [message] optional default *
 *	@param params array Query parameters (with 'conn') [message] optional default input
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param not boolean Value check nonequal [message] optional default true
 *	@param errormsg string Error message [message] optional default 'Error in Database'
 *	@param attribute string Column name [message] optional default ''
 *
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return result array/attribute Result tuple or value [memory] 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class RelationUniqueWorkflow implements Service {
	
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
		$not = isset($message['not']) ? $message['not'] : true;
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Error in Database';
		$attribute = isset($message['attribute']) ? '.'.$message['attribute'] : '';
		
		$workflow = array(
		array(
			'service' => 'sb.query.execute.workflow',
			'input' => $params,
			'output' => array('sqlresult' => $relation),
			'query' => 'select '.$sqlprj.' from '.$relation.' '.$sqlcnd.';',
			'escparam' => $escparam,
			'not' => $not,
			'errormsg' => $errormsg
		),
		array(
			'service' => 'sbcore.data.select.service',
			'input' => array($relation => $relation),
			'output' => array($relation => $relation),
			'params' => array($relation.'.0'.$attribute => 'result')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>