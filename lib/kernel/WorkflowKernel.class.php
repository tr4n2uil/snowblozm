<?php 

require_once(SBSERVICE);

/**
 *	@class WorkflowKernel
 *	@desc Provides core functionality of the enhanced kernel for executing services and workflows
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class WorkflowKernel {
	
	/** 
	 *	@method execute
	 *	@desc Runs a workflow by using its definition array
	 *				workflow [{
	 *					service => ...,
	 *					... params ...
	 *				}]
	 *
	 *	@param $workflow Workflow definition array
	 *	@param $memory object optional default array('valid' = true)
	 *
	 *	@return $memory object
	 *
	**/
	public function execute($workflow, $memory = array()){
		$memory['valid'] = isset($memory['valid']) ? $memory['valid'] : true;
		
		foreach($workflow as $defn){			
			/**
			 *	Run the service with the message (defn itself) and memory
			**/
			$memory = $this->run($defn, $memory);
			
			/**
			 *	Break on invalid state
			**/
			if(!$memory['valid'])
				break;
		}
		
		/**
		 *	Return memory
		**/
		return $memory;
	}
	
	/** 
	 *	@method run
	 *	@desc Runs a service by using its definition object
	 *				service {
	 *					service => ...,
	 *					... params ...
	 *				}
	 *
	 *	@param $defn Service definition
	 *	@param $memory object ooptional default array('valid' => true)
	 *
	 *	@return $memory object
	 *
	**/
	public function run($defn, $memory = array()){
		$memory['valid'] = isset($memory['valid']) ? $memory['valid'] : true;
		
		/**
		 *	Read the service instance
		**/
		$service = $defn['service'];
			
		/**
		 *	Run the service with the message (defn itself) and memory
		**/
		return $service->run($defn, $memory);
	}
	
}

?>
