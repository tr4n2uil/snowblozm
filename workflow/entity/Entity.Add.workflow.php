<?php 
require_once(SBSERVICE);

/**
 *	@class EntityAddWorkflow
 *	@desc Adds new entity information
 *
 *	@param entity string Entity name [message]
 *	@param table string Table name [message] optional default entity.'s'
 *	@param sqlcnd string SQL condition [message]
 *	@param reqparam array Request parameters [message]
 *	@param defparam array Default params [message] optional default array()
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param qryparam array Query parameters [message] optional default reqparam
 *
 *	@param request-type string Request type [message] ('get, 'post', 'memory', 'json', 'xml', 'wddx')
 *	@param response-type string Response type [message] ('memory', 'json, 'xml', 'wddx', 'html', 'plain')
  *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class EntityAddWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$entity = $message['entity'];
		$table = isset($message['table']) ? $message['table'] : $entity.'s';
		$sqlcnd = $message['sqlcnd'];
		$reqparam = isset($message['reqparam']) ? $message['reqparam'] : array();
		$defparam = isset($message['defparam']) ? $message['defparam'] : array();
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$qryparam = isset($message['qryparam']) ? $message['qryparam'] : $reqparam;
		
		$workflow = array(
		array(
			'service' => 'sb.request.read.service',
			'output' => $reqparam,
			'defparam' => $defparam,
			'type' => $message['request-type']
		),
		array(
			'service' => 'sb.query.execute.workflow',
			'input' => array_merge($qryparam, array('conn' => 'conn')),
			'output' => array('sqlresult' => $entity),
			'query' => 'insert into '.$table.' '.$sqlcnd.';',
			'rstype' => 2,
			'escparam' => $escparam,
		),array(
			'service' => 'sb.string.substitute.service',
			'input' => array($entity => 'id'),
			'output' => array('result' => 'successmsg'),
			'data' => ucfirst($entity).' added successfully ID : ${id}'
		),
		array(
			'service' => 'sb.response.write.service',
			'input' => array('sqlresult' => 'id', 'successmsg' => 'successmsg'),
			'strict' => false,
			'type' => $message['response-type']
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>