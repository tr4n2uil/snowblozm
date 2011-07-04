<?php 
require_once(SBSERVICE);

/**
 *	@class QueryExecuteWorkflow
 *	@desc Executes query by performing escapes and substitutions and validates result
 *
  *	@param conn resource DataService instance [memory]
 *	@param query string SQL Query to be executed with substitutions [message|memory]
 *	@param flag boolean Is result set unexpected [message] optional default false
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param qryparam array Query parameters [message] optional default input-'query'
 *	@param count integer Validation count [message] optional default 1
 *	@param not boolean Error on nonequality [message] optional default true
 *	@param errormsg string Error message on validation failure [message] optional default 'Invalid Query Results'
 *
 *	@return sqlresult array/integer Result set / affected row count [memory]
 *	@return sqlrc integer Row count [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class QueryExecuteWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$query = isset($message['query']) ? $message['query'] : $memory['query'];
		$flag = isset($message['flag']) ? $message['flag'] : false;
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$qryparam = isset($message['qryparam']) ? $message['qryparam'] : $message['input'];
		$count = isset($message['count']) ? $message['count'] : 1;
		$not = isset($message['not']) ? $message['not'] : true;
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid Query Results';
		
		if(isset($qryparam['query'])) 
			unset($qryparam['query']);
		if(isset($qryparam['conn'])) 
			unset($qryparam['conn']);
			
		$escout = $escparam;
		$escparam['conn'] = 'conn';
		
		$workflow = array(
		array(
			'service' => 'sb.query.escape.service',
			'input' => $escparam,
			'output' => $escparam
		),
		array(
			'service' => 'sb.string.substitute.service',
			'input' => $qryparam,
			'output' => array('result' => 'query'),
			'data' => $query
		),
		array(
			'service' => 'sb.query.execute.service',
			'input' => array('query' => 'query', 'conn' => 'conn'),
			'output' => array('sqlresult' => 'sqlresult', 'sqlrowcount' => 'sqlrc'),
			'flag' => $flag
		),
		array(
			'service' => 'sb.data.equal.service',
			'input' => array('sqlrc' => 'data'),
			'value' => $count,
			'not' => $not,
			'errormsg' => $errormsg
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>