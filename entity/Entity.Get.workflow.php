<?php 
require_once(SBSERVICE);

/**
 *	@class EntityGetWorkflow
 *	@desc Returns the information for entity satisfying conditions
 *
 *	@param entity string Entity name [message]
 *	@param table string Table name [message] optional default entity.'s'
 *	@param where string SQL where condition [message]
 *	@param reqparam array Request parameters [message]
 *	@param escparam array Escape parameters [message] optional default array()
 *	@param qryparam array Query parameters [message] optional default reqparam
 *	@param errormsg string Error message if unique entity not found [message] optional default 'Invalid Credentials'
 *	@param successmsg string Success message [message] optional default 'Successfully Executed'
 *	@param not boolean Value check nonequal [message] optional default true
 *
 *	@return entity array Entity information [memory]
 *
**/
class EntityGetWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$ml = new ModuleLoader();
		$kernel = new WorkflowKernel();
		$workflow = array();
		
		$entity = $message['entity'];
		$table = isset($message['table']) ? $message['table'] : $entity.'s';
		$where = $message['where'];
		$reqparam = $message['reqparam'];
		$escparam = isset($message['escparam']) ? $message['escparam'] : array();
		$qryparam = isset($message['qryparam']) ? $message['qryparam'] : $reqparam;
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid Credentials';
		
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
		$mdl['basestr'] = 'select * from '.$table.' where '.$where.';';
		$mdl['params'] = $qryparam;
		$mdl['resultkey'] = 'query';
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('query.execute.service', SBROOT));
		array_push($workflow, $mdl);
		
		$mdl = array('service' => $ml->load('value.equal.service', SBROOT));
		$mdl['key'] = 'sqlrowcount';
		$mdl['value'] = 1;
		if(isset($message['not']))
			$mdl['not'] = $message['not'];
		$mdl['errormsg'] = $errormsg;
		array_push($workflow, $mdl);
		
		$memory = $kernel->execute($workflow, $memory);

		$mdl = array('service' => $ml->load('response.write.service', SBROOT));
		if(!isset($message['not']) || $message['not'])
			$mdl['params'] = array('sqlresult' => $entity);
		if(isset($message['successmsg']))
			$mdl['successmsg'] = $message['successmsg'];
		$mdl['type'] = $type[1];
		
		$memory = $kernel->run($mdl, $memory);
		return $memory;
	}
	
}

?>