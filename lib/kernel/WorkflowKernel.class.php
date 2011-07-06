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
	 *					input => ...,
	 *					output => ...,
	 *					strict => ...,
	 *					... params ...
	 *				}]
	 *
	 *	@param $workflow Workflow definition array
	 *	@param $memory object optional default array()
	 *
	 *	@return $memory object
	 *
	**/
	public function execute($workflow, $memory = array()){
		$memory['valid'] = isset($memory['valid']) ? $memory['valid'] : true;
		
		foreach($workflow as $defn){
			/**
			 *	Check for strictness
			**/
			$strict = isset($defn['strict']) ? $defn['strict'] : true;
			
			/**
			 *	Continue on invalid state
			**/
			if(!$memory['valid'] && $strict)
				continue;
			
			/**
			 *	Run the service with the message (defn itself) and memory
			**/
			$memory = $this->run($defn, $memory);
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
	 *					input => ...,
	 *					output => ...,
	 *					strict => ...,
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
		$default = array('valid', 'msg', 'status', 'details');
		
		/**
		 *	Read the service uri and load an instance
		**/
		$service = Snowblozm::load($defn['service']);
		
		/**
		 *	Read the service input
		**/
		$input = isset($defn['input']) ? $defn['input'] : array();
		$strict = isset($defn['strict']) ? $defn['strict'] : true;
		
		/**
		 *	Construct service request
		**/
		$request = array();
		
		foreach($input as $key => $value){
			if(!isset($memory[$key])){
				if(!$strict) continue;
				
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Service Request';
				$memory['status'] = 500;
				$memory['details'] = 'Value not found for '.$key.' @WorkflowKernel/run '.$defn['service'];
				return $memory;
			}
			$request[$value] = $memory[$key];
		}
		
		foreach($default as $key){
			if(isset($memory[$key])){
				$request[$key] = $memory[$key];
			}
		}
			
		/**
		 *	Run the service with the message (defn itself) and request as memory
		**/
		$response = $service->run($defn, $request);
		
		/**
		 *	Read the service output
		**/
		$output = isset($defn['output']) && $response['valid'] ? $defn['output'] : array();
		
		/**
		 *	Read service response into memory
		**/
		foreach($default as $key){
			if(isset($response[$key])){
				$memory[$key] = $response[$key];
			}
		}
		
		if(!$memory['valid'])
			return $memory;
		
		foreach($output as $key => $value){
			if(!isset($response[$key])){
				if(!$strict) continue;
				
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Service Response';
				$memory['status'] = 501;
				$memory['details'] = 'Value not found for '.$key.' @WorkflowKernel/run '.$defn['service'];
				return $memory;
			}
			$memory[$value] = $response[$key];
		}
		
		/**
		 *	Return the memory
		**/
		return $memory;
	}
	
}

?>
