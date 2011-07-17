<?php 
require_once(SBSERVICE);

/**
 *	@class EntityInfoWorkflow
 *	@desc Returns the information for entity
 *
 *	@param entity string Entity name [message]
 *	@param table string Table name [message] optional default entity.'s'
 *	@param id string Entity ID key [message]
 *	@param sqlprj string SQL projection [message] optional default *
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
class EntityInfoWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$entity = $message['entity'];
		$id = $message['id'];
		$table = isset($message['table']) ? $message['table'] : $entity.'s';
		$sqlprj = isset($message['sqlprj']) ? $message['sqlprj'] : '*';
		
		$workflow = array(
		array(
			'service' => 'sbcore.request.read.service',
			'output' => array($id => $id),
			'type' => $message['request-type']
		),
		array(
			'service' => 'sb.query.execute.workflow',
			'input' => array($id => $id, 'conn' => 'conn'),
			'output' => array('sqlresult' => $entity),
			'query' => 'select '.$sqlprj.' from '.$table.' where '.$id.'=${'.$id.'};',
			'errormsg' => 'Invalid '.ucfirst($entity).' ID'
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
			'input' => array($entity => $entity),
			'strict' => false,
			'type' => $message['response-type']
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>