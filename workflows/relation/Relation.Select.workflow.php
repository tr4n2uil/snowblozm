<?php 
require_once(SBSERVICE);

/**
 *	@class RelationSelectWorkflow
 *	@desc Executes SELECT query on relation returning all results in resultset
 *
 *	@param relation string Relation name [memory]
 *	@param sqlcnd string SQL condition [memory]
 *	@param sqlprj string SQL projection [memory] optional default *
 *	@param args array Query parameters [args]
 *	@param escparam array Escape parameters [memory] optional default array()
 *	@param errormsg string Error message [memory] optional default 'Error in Database'
 *
 *	@param conn array DataService instance configuration key [memory]
 *
 *	@return relation array Resultset [memory] 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class RelationSelectWorkflow implements Service {
	
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
			'optional' => array('sqlprj' => '*', 'escparam' => array(), 'errormsg' => 'Error in Database')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$this->relation = $memory['relation'];

		$service = array(
			'service' => 'sb.query.execute.workflow',
			'args' => $memory['args'],
			'output' => array('sqlresult' => $this->relation),
			'query' => 'select '.$memory['sqlprj'].' from '.$this->relation.' '.$memory['sqlcnd'].';',
			'count' => 0,
			'not' => false
		);
		
		return $kernel->run($service, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array($this->relation);
	}
	
}

?>