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
	 *					... message params ...
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
			 *	Continue on invalid state if strict
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
		$sin = $service->input();
		$sinreq = isset($sin['required']) ? $sin['required'] : array();
		$sinopt = isset($sin['optional']) ? $sin['optional'] : array();
		
		/**
		 *	Construct service request
		**/
		$request = array();
		
		/**
		 *	@debug
		**/
		//echo $defn['service'].' IN '.json_encode($memory).'<br />';
		
		/**
		 *	Copy required input
		**/
		foreach($sinreq as $key){
			$param = isset($input[$key]) ? $input[$key] : $key;
			if(!isset($memory[$param])){				
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Service Input Parameters';
				$memory['status'] = 500;
				$memory['details'] = 'Value not found for '.$key.' @'.$defn['service'];
				return $memory;
			}
			$request[$key] = $memory[$param];
		}
		
		/**
		 *	Copy optional input
		**/
		foreach($sinopt as $key => $value){
			$param = isset($input[$key]) ? $input[$key] : $key;
			if(!isset($memory[$param])){				
				$request[$key] = $value;
				continue;
			}
			$request[$key] = $memory[$param];
		}
		
		/**
		 *	Copy default input
		**/
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
		$sout = $service->output();
		//$soutreq = isset($sout['required']) ? $sout['required'] : array();
		//$soutopt = isset($sout['optional']) ? $sout['optional'] : array();
		
		/**
		 *	Copy default output
		**/
		foreach($default as $key){
			if(isset($response[$key])){
				$memory[$key] = $response[$key];
			}
		}
		
		if(!$memory['valid'])
			return $memory;
		
		/**
		 *	Copy required output
		**/
		foreach($sout as $key){
			$param = isset($output[$key]) ? $output[$key] : $key;
			if(!isset($response[$key])){				
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Service Output Parameters';
				$memory['status'] = 501;
				$memory['details'] = 'Value not found for '.$key.' @'.$defn['service'];
				return $memory;
			}
			$memory[$param] = $response[$key];
		}
		
		/**
		 *	Copy optional output
		**
		foreach($soutopt as $key => $value){
			$param = isset($output[$key]) ? $output[$key] : $key;
			if(!isset($response[$key])){				
				$memory[$param] = $value;
				continue;
			}
			$memory[$param] = $response[$key];
		}*/
		
		/**
		 *	@debug
		**/
		//echo $defn['service'].' OUT '.json_encode($memory).'<br />';
		
		/**
		 *	Return the memory
		**/
		return $memory;
	}
	
}

?>
