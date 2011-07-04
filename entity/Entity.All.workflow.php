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
 *	@return entity array Entity information [memory]
 *
**/
class EntityAllWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$ml = new ModuleLoader();
		$kernel = new WorkflowKernel();
		$workflow = array();
		
		$entity = $message['entity'];
		$table = isset($message['table']) ? $message['table'] : $entity.'s';
		$sqlcnd = $message['sqlcnd'];
		$reqparam = isset($message['reqparam']) ? $message['reqparam'] : array();
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$qryparam = isset($message['qryparam']) ? $message['qryparam'] : $reqparam;
		
		$type = isset($message['type']) ? $message['type'] : (isset($memory['type']) ? $memory['type'] : 'post.json');
		$type = explode('.', $type);
		if(count($type) == 1)
			$type[1] = $type[0];
		
		$mdl = array('service' => $ml->load('request.read.service', SBROOT));
		$mdl['params'] = $reqparam;
		$mdl['type'] = $type[0];
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('query.escape.service', SBROOT));
		$mdl['params'] = $escparam;
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('string.substitute.service', SBROOT));
		$mdl['basestr'] = 'select * from '.$table.' '.$sqlcnd.';';
		$mdl['params'] = $qryparam;
		$mdl['resultkey'] = 'query';
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('query.execute.service', SBROOT));
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('value.equal.service', SBROOT));
		$mdl['key'] = 'sqlrowcount';
		$mdl['value'] = 0;
		$mdl['not'] = false;
		$mdl['errormsg'] = 'Error in Database';
		array_push($workflow, $mdl);
		
		$memory = $kernel->execute($workflow, $memory);

		$mdl = array('service' => $ml->load('response.write.service', SBROOT));
		$mdl['params'] = array('sqlresult' => $table);
		$mdl['type'] = $type[1];
		
		$memory = $kernel->run($mdl, $memory);
		return $memory;
	}
	
}

?>