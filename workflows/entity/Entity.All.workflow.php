<?php 
require_once(SBSERVICE);

/**
 *	@class EntityAllWorkflow
 *	@desc Returns the information for all entity
 *
 *	@param entity string Entity name [message]
 *	@param sqlcnd string SQL condition [message]
 *	@param sqlprj string SQL projection [message] optional default *
 *	@param reqparam array Request parameters [message] optional default array()
 *	@param defparam array Default params [message] optional default array()
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param qryparam array Query parameters [message] optional default reqparam
 *	@param errormsg string Error message [message] optional default 'Error in Database'
 *
 *	@param request-type string Request type [message] ('get, 'post', 'memory', 'json', 'xml', 'wddx')
 *	@param response-type string Response type [message] ('memory', 'json, 'xml', 'wddx', 'html', 'plain')
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return table array Entity information [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class EntityAllWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$entity = $message['entity'];
		$table = isset($message['table']) ? $message['table'] : $entity.'s';
		$sqlcnd = $message['sqlcnd'];
		$sqlprj = isset($message['sqlprj']) ? $message['sqlprj'] : '*';
		$reqparam = isset($message['reqparam']) ? $message['reqparam'] : array();
		$defparam = isset($message['defparam']) ? $message['defparam'] : array();
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$qryparam = isset($message['qryparam']) ? $message['qryparam'] : $reqparam;
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Error in Database';
		
		$workflow = array(
		array(
			'service' => 'sbcore.request.read.service',
			'output' => $reqparam,
			'defparam' => $defparam,
			'type' => $message['request-type']
		),
		array(
			'service' => 'sb.query.execute.workflow',
			'input' => array_merge($qryparam, array('conn' => 'conn')),
			'output' => array('sqlresult' => $table),
			'query' => 'select '.$sqlprj.' from '.$table.' '.$sqlcnd.';',
			'escparam' => $escparam,
			'count' => 0,
			'not' => false,
			'errormsg' => $errormsg
		),
		array(
			'service' => 'sbcore.response.write.service',
			'input' => array($table => $table),
			'strict' => false,
			'type' => $message['response-type']
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>