<?php 
require_once(SBSERVICE);

/**
 *	@class EntityGetWorkflow
 *	@desc Returns the information for entity satisfying conditions
 *
 *	@param entity string Entity name [message]
 *	@param table string Table name [message] optional default entity.'s'
 *	@param sqlcnd string SQL condition [message]
 *	@param sqlprj string SQL projection [message] optional default *
 *	@param reqparam array Request parameters [message]
 *	@param defparam array Default params [message] optional default array()
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param qryparam array Query parameters [message] optional default reqparam
 *	@param not boolean Value check nonequal [message] optional default true
 *	@param errormsg string Error message if unique entity not found [message] optional default 'Invalid Credentials'
 *	@param successmsg string Success message [message] optional default 'Successfully executed'
 *
 *	@param request-type string Request type [message] ('get, 'post', 'memory', 'json', 'xml', 'wddx')
 *	@param response-type string Response type [message] ('memory', 'json, 'xml', 'wddx', 'html', 'plain')
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@return entity array Entity information [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class EntityGetWorkflow implements Service {
	
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
		$not = isset($message['not']) ? $message['not'] : true;
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid Credentials';
		$successmsg = isset($message['successmsg']) ? $message['successmsg'] : 'Successfully executed';
		
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
			'output' => array('sqlresult' => $entity),
			'query' => 'select '.$sqlprj.' from '.$table.' '.$sqlcnd.';',
			'escparam' => $escparam,
			'count' => 1,
			'not' => $not,
			'errormsg' => $errormsg
		),
		array(
			'service' => 'sbcore.data.select.service',
			'input' => array($entity => $entity),
			'output' => array($entity => $entity),
			'params' => array($entity.'.0' => $entity),
			'type' => $message['request-type']
		),
		array(
			'service' => 'sbcore.response.write.service',
			'input' => ($not ? array($entity => $entity) : array()),
			'strict' => false,
			'successmsg' => $successmsg,
			'type' => $message['response-type']
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>