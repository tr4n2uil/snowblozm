<?php 
require_once(SBSERVICE);

/**
 *	@class EntityAllWorkflow
 *	@desc Returns the information for all entity
 *
 *	@param entity string Entity name [message]
 *	@param sqlcnd string SQL condition [message]
 *	@param reqparam array Request parameters [message] optional default array()
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param qryparam array Query parameters [message] optional default reqparam
 *
 *	@param request-type string Request type [message] ('get, 'post', 'memory', 'json', 'xml', 'wddx')
 *	@param response-type string Response type [message] ('memory', 'json, 'xml', 'wddx', 'html', 'plain')
 *	@param conn resource DataService instance [memory]
 *
 *	@return table array Entity information [memory]
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
		$reqparam = isset($message['reqparam']) ? $message['reqparam'] : array();
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$qryparam = isset($message['qryparam']) ? $message['qryparam'] : $reqparam;
		
		$workflow = array(
		array(
			'service' => 'sb.request.read.service',
			'output' => $reqparam,
			'type' => $message['request-type']
		),
		array(
			'service' => 'sb.query.execute.workflow',
			'input' => array_merge($qryparam, array('conn' => 'conn')),
			'output' => array('sqlresult' => $table),
			'query' => 'select * from '.$table.' '.$sqlcnd.';',
			'escparam' => $escparam,
			'count' => 0,
			'not' => false,
			'errormsg' => 'Error in Database'
		));
		
		$memory = $kernel->execute($workflow, $memory);
		
		$mdl = array(
			'service' => 'sb.response.write.service',
			'input' => array($table => $table),
			'strict' => false,
			'type' => $message['response-type']
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>