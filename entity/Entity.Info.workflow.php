<?php 
require_once(SBSERVICE);

/**
 *	@class EntityInfoWorkflow
 *	@desc Returns the information for entity
 *
 *	@param entity string Entity name [message]
 *	@param table string Table name [message] optional default entity.'s'
 *	@param id string Entity ID key [message]
 *
 *	@return entity array Entity information [memory]
 *
**/
class EntityInfoWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$ml = new ModuleLoader();
		$kernel = new WorkflowKernel();
		$workflow = array();
		
		$entity = $message['entity'];
		$id = $message['id'];
		$table = isset($message['table']) ? $message['table'] : $entity.'s';
		
		$type = isset($message['type']) ? $message['type'] : (isset($memory['type']) ? $memory['type'] : 'post.json');
		$type = explode('.', $type);
		if(count($type) == 1)
			$type[1] = $type[0];
		
		$mdl = array('service' => $ml->load('request.read.service', SBROOT));
		$mdl['params'] = array($id);
		$mdl['type'] = $type[0];
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('string.substitute.service', SBROOT));
		$mdl['basestr'] = 'select * from '.$table.' where '.$id.'=${'.$id.'};';
		$mdl['params'] = array($id);
		$mdl['resultkey'] = 'query';
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('query.execute.service', SBROOT));
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('value.equal.service', SBROOT));
		$mdl['key'] = 'sqlrowcount';
		$mdl['value'] = 1;
		$mdl['errormsg'] = 'Invalid '.ucfirst($entity).' ID';
		array_push($workflow, $mdl);
		
		$memory = $kernel->execute($workflow, $memory);

		$mdl = array('service' => $ml->load('response.write.service', SBROOT));
		$mdl['params'] = array('sqlresult' => $entity);
		$mdl['type'] = $type[1];
		
		$memory = $kernel->run($mdl, $memory);
		return $memory;
	}
	
}

?>