<?php 
require_once(SBSERVICE);

/**
 *	@class EntityGetWorkflow
 *	@desc Returns the information for entity satisfying conditions
 *
 *	@param entity string Entity name [message]
 *	@param table string Table name [message] optional default entity.'s'
 *	@param sqlcnd string SQL condition [message]
 *	@param reqparam array Request parameters [message]
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param qryparam array Query parameters [message] optional default reqparam
 *	@param not boolean Value check nonequal [message] optional default true
 *	@param errormsg string Error message if unique entity not found [message] optional default 'Invalid Credentials'
 *	@param successmsg string Success message [message] optional default 'Successfully executed'
 *
 *	@param request-type string Request type [message] ('get, 'post', 'memory', 'json', 'xml', 'wddx')
 *	@param response-type string Response type [message] ('memory', 'json, 'xml', 'wddx', 'html', 'plain')
 *	@param conn resource DataService instance [memory]
 *
 *	@return entity array Entity information [memory]
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
		$reqparam = isset($message['reqparam']) ? $message['reqparam'] : array();
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$qryparam = isset($message['qryparam']) ? $message['qryparam'] : $reqparam;
		$not = isset($message['not']) ? $message['not'] : true;
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid Credentials';
		$successmsg = isset($message['successmsg']) ? $message['successmsg'] : 'Successfully executed';
		
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
			'query' => 'select * from '.$table.' '.$sqlcnd.';',
			'escparam' => $escparam,
			'count' => 1,
			'not' => $not,
			'errormsg' => $errormsg
		));
		
		$memory = $kernel->execute($workflow, $memory);
		
		$mdl = array(
			'service' => 'sb.response.write.service',
			'input' => ($not ? array($entity => $entity) : array()),
			'strict' => false,
			'successmsg' => $successmsg,
			'type' => $message['response-type']
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>