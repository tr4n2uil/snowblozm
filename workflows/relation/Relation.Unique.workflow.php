<?php 
require_once(SBSERVICE);

/**
 *	@class RelationUniqueWorkflow
 *	@desc Executes SELECT query on relation returning unique result, if any, in resultset
 *
 *	@param relation string Relation name [memory]
 *	@param sqlcnd string SQL condition [memory]
 *	@param sqlprj string SQL projection [memory] optional default *
 *	@param args array Query parameters [args]
 *	@param escparam array Escape parameters [memory] optional default array()
 *	@param not boolean Value check nonequal [memory] optional default true
 *	@param errormsg string Error message [memory] optional default 'Error in Database'
 *
 *	@param conn array DataService instance configuration key [memory]
 *
 *	@return result array/attribute Result tuple or value [memory] 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class RelationUniqueWorkflow implements Service {
	
	/**
	 *	@var relation 
	**/
	private $relation;
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('conn', 'relation', 'sqlcnd'),
			'optional' => array('sqlprj' => '*', 'escparam' => array(), 'errormsg' => 'Error in Database', 'not' => true)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$this->relation = $message['relation'];
		
		$workflow = array(
		array(
			'service' => 'sb.query.execute.workflow',
			'args' => $memory['args'],
			'output' => array('sqlresult', $this->relation),
			'query' => 'select '.$memory['sqlprj'].' from '.$this->relation.' '.$memory['sqlcnd'].';'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'args' => array($this->relation),
			'params' => array($this->relation.'.0' => $this->relation)
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array($this->relation);
	}
	
}

?>