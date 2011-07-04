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
 *	@param conn resource DataService instance [memory]
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
			'service' => 'sb.request.read.service',
			'output' => array($id => $id),
			'type' => $message['request-type']
		),
		array(
			'service' => 'sb.query.execute.workflow',
			'input' => array($id => $id, 'conn' => 'conn'),
			'output' => array('sqlresult' => $entity),
			'query' => 'delete from '.$table.' where '.$id.'=${'.$id.'};',
			'flag' => true,
			'errormsg' => 'Invalid '.ucfirst($entity).' ID'
		),
		array(
			'service' => 'sb.string.substitute.service',
			'input' => array($id => $id),
			'output' => array('result' => 'successmsg'),
			'data' => ucfirst($entity).' deleted successfully ID : ${'.$id.'}'
		));
		
		$memory = $kernel->execute($workflow, $memory);
		
		$mdl = array(
			'service' => 'sb.response.write.service',
			'input' => array($entity => $entity, 'successmsg' => 'successmsg'),
			'strict' => false,
			'type' => $message['response-type']
		);
		
		return $kernel->run($mdl, $memory);
	}
	
}

?>