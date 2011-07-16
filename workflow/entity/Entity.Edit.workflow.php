<?php 
require_once(SBSERVICE);

/**
 *	@class EntityEditWorkflow
 *	@desc Edits entity information
 *
 *	@param entity string Entity name [message]
 *	@param table string Table name [message] optional default entity.'s'
 *	@param sqlcnd string SQL condition [message]
 *	@param reqparam array Request parameters [message]
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param qryparam array Query parameters [message] optional default reqparam
 *	@param errormsg string Error message if unique entity not found [message] optional default 'Invalid $entity'
 *	@param successmsg string Success message [message] optional default 'Successfully executed'
 *
 *	@param request-type string Request type [message] ('get, 'post', 'memory', 'json', 'xml', 'wddx')
 *	@param response-type string Response type [message] ('memory', 'json, 'xml', 'wddx', 'html', 'plain')
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class EntityEditWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$entity = $message['entity'];
		$table = isset($message['table']) ? $message['table'] : $entity.'s';
		$sqlcnd = $message['sqlcnd'];
		$reqparam = isset($message['reqparam']) ? $message['reqparam'] : array();
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$qryparam = isset($message['qryparam']) ? $message['qryparam'] : $reqparam;
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid '.ucfirst($entity).' / Not permitted';
		$successmsg = isset($message['successmsg']) ? $message['successmsg'] : ucfirst($entity).' edited successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.request.read.service',
			'output' => $reqparam,
			'type' => $message['request-type']
		),
		array(
			'service' => 'sb.query.execute.workflow',
			'input' => array_merge($qryparam, array('conn' => 'conn')),
			'output' => array('sqlresult' => $entity),
			'query' => 'update '.$table.' '.$sqlcnd.';',
			'rstype' => 1,
			'escparam' => $escparam,
			'errormsg' => $errormsg
		),
		array(
			'service' => 'sb.response.write.service',
			'strict' => false,
			'successmsg' => $successmsg,
			'type' => $message['response-type']
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>