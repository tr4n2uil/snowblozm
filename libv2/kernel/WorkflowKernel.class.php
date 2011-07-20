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
		
		foreach($workflow as $message){
			/**
			 *	Check for strictness
			**/
			$strict = isset($message['strict']) ? $message['strict'] : true;
			
			/**
			 *	Continue on invalid state if strict
			**/
			if(!$memory['valid'] && $strict)
				continue;
			
			/**
			 *	Run the service with the message and memory
			**/
			$memory = $this->run($message, $memory);
		}
		
		/**
		 *	Return memory
		**/
		return $memory;
	}
	
	/** 
	 *	@method run
	 *	@desc Runs a service by using its definition message object
	 *				service {
	 *					service => ...,
	 *					input => ...,
	 *					output => ...,
	 *					strict => ...,
	 *					... params ...
	 *				}
	 *
	 *	@param $message Service definition message
	 *	@param $memory object optional default array('valid' => true)
	 *
	 *	@return $memory object
	 *
	**/
	public function run($message, $memory = array()){
		$memory['valid'] = isset($memory['valid']) ? $memory['valid'] : true;
		$default = array('valid', 'msg', 'status', 'details');
		
		/**
		 *	Read the service uri and load an instance
		**/
		$service = Snowblozm::load($message['service']);
		
		/**
		 *	Read the service arguments
		**/
		$args = isset($message['args']) ? $message['args'] : array();
		
		/**
		 *	Copy arguments if necessary
		**/
		foreach($args as $key){
			if(!isset($message[$key])){
				$message[$key] = isset($memory[$key]) ? $memory[$key] : false;
			}
		}
		
		/**
		 *	Read the service input
		**/
		$input = isset($message['input']) ? $message['input'] : array();
		$sin = $service->input();
		$sinreq = isset($sin['required']) ? $sin['required'] : array();
		$sinopt = isset($sin['optional']) ? $sin['optional'] : array();
		
		/**
		 *	Copy required input if not exists
		**/
		foreach($sinreq as $key){
			if(!isset($message[$key])){
				$param = isset($input[$key]) ? $input[$key] : $key;
				if(!isset($memory[$param])){				
					$memory['valid'] = false;
					$memory['msg'] = 'Invalid Service Input Parameters';
					$memory['status'] = 500;
					$memory['details'] = 'Value not found for '.$key.' @'.$message['service'];
					return $memory;
				}
				$message[$key] = $memory[$param];
			}
		}
		
		/**
		 *	Copy optional input if not exists
		**/
		foreach($sinopt as $key => $value){
			if(!isset($message[$key])){
				$param = isset($input[$key]) ? $input[$key] : $key;
				if(!isset($memory[$param])){				
					$message[$key] = $value;
					continue;
				}
				$message[$key] = $memory[$param];
			}
		}
		
		/**
		 *	Copy default input if exists
		**/
		foreach($default as $key){
			if(isset($memory[$key])){
				$message[$key] = $memory[$key];
			}
		}
		
		/**
		 *	@debug
		**/
		if(Snowblozm::$debug){
			echo 'IN '.json_encode($message).'<br /><br />';
		}
			
		/**
		 *	Run the service with the message as memory
		**/
		$message = $service->run($message);
		
		/**
		 *	@debug
		**/
		if(Snowblozm::$debug){
			echo 'OUT '.json_encode($message).'<br /><br />';
		}
		
		/**
		 *	Read the service output
		**/
		$output = isset($message['output']) && $message['valid'] ? $message['output'] : array();
		$sout = $service->output();
		
		/**
		 *	Copy default output
		**/
		foreach($default as $key){
			if(isset($message[$key])){
				$memory[$key] = $message[$key];
			}
		}
		
		/**
		 *	Return if not valid
		**/
		if(!$memory['valid'])
			return $memory;
		
		/**
		 *	Copy output
		**/
		foreach($sout as $key){
			$param = isset($output[$key]) ? $output[$key] : $key;
			if(!isset($message[$key])){				
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Service Output Parameters';
				$memory['status'] = 501;
				$memory['details'] = 'Value not found for '.$key.' @'.$message['service'];
				return $memory;
			}
			$memory[$param] = $message[$key];
		}
		
		/**
		 *	Return the memory
		**/
		return $memory;
	}
	
}

?>
