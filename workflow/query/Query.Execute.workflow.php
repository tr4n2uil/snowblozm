<?php 
require_once(SBSERVICE);

/**
 *	@class QueryExecuteWorkflow
 *	@desc Executes query by performing escapes, checks and substitutions and validates result
 *
  *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *	@param query string SQL Query to be executed with substitutions [message|memory]
 *	@param rstype integer type of result [message] optional default 0
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param numparam array Number parameters [message] optional default qryparam-escparam
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
		$rstype = isset($message['rstype']) ? $message['rstype'] : 0;
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$qryparam = isset($message['qryparam']) ? $message['qryparam'] : $message['input'];
		
		if(isset($qryparam['query'])) 
			unset($qryparam['query']);
			
		if(isset($qryparam['conn'])) 
			unset($qryparam['conn']);
		
		$numparam = isset($message['numparam']) ? $message['numparam'] : array_diff($qryparam, $escparam);
		$count = isset($message['count']) ? $message['count'] : 1;
		$not = isset($message['not']) ? $message['not'] : true;
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid Query Results';
			
		$escout = $escparam;
		$escparam['conn'] = 'conn';
		
		$conn = $memory['conn'];
		switch($conn['type']){
			case 'mysql' :
			default :
				require_once(SBMYSQL);
				$dataservice = new Mysql($conn['database'], $conn['user'], $conn['pass'], $conn['host']);
				break;
		}
		$memory['conn'] = $dataservice;
		
		$workflow = array(
		array(
			'service' => 'sb.data.numeric.service',
			'input' => $numparam
		),
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
			'rstype' => $rstype
		),
		array(
			'service' => 'sb.data.equal.service',
			'input' => array('sqlrc' => 'data'),
			'value' => $count,
			'not' => $not,
			'errormsg' => $errormsg
		));
		
		$memory = $kernel->execute($workflow, $memory);
		$dataservice->close();
		
		return $memory;
	}
	
}

?>