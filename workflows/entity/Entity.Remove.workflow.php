<?php 
require_once(SBSERVICE);

/**
 *	@class EntityRemoveWorkflow
 *	@desc Removes the entity with id
 *
 *	@param entity string Entity name [message]
 *	@param table string Table name [message] optional default entity.'s'
 *	@param id string Entity ID key [message]
 *
 *	@param request-type string Request type [message] ('get, 'post', 'memory', 'json', 'xml', 'wddx')
 *	@param response-type string Response type [message] ('memory', 'json, 'xml', 'wddx', 'html', 'plain')
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class EntityRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$entity = $message['entity'];
		$id = $message['id'];
		$table = isset($message['table']) ? $message['table'] : $entity.'s';
		
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
			'query' => 'delete from '.$table.' where '.$id.'=${'.$id.'};',
			'rstype' => 1,
			'errormsg' => 'Invalid '.ucfirst($entity).' ID'
		),
		array(
			'service' => 'sbcore.string.substitute.service',
			'input' => array($id => $id),
			'output' => array('result' => 'successmsg'),
			'data' => ucfirst($entity).' deleted successfully ID : ${'.$id.'}'
		),
		array(
			'service' => 'sbcore.response.write.service',
			'input' => array($entity => $entity, 'successmsg' => 'successmsg'),
			'strict' => false,
			'type' => $message['response-type']
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>