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
	 *	@param $cmp Component
	 *	@param $model object
	 *
	 *	@return $model object
	 *
	**/
	public function execute($workflow, $memory = array('valid' => true)){
		
		foreach($workflow as $defn){
			/**
			 *	Read the service instance
			**/
			$service = $defn['service'];
			
			/**
			 *	Run the service with the message (defn itself) and memory
			**/
			$memory = $service->run($defn, $memory);
			
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
	
}

?>
