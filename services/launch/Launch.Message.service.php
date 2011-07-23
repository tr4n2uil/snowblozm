<?php 
require_once(SBSERVICE);

/**
 *	@class LaunchMessageService
 *	@desc Launches workflows from messages
 *
 *	@param message array Message to be launched [memory]
 *	@param access array Array of allowed values for controlling workflows executed [memory] optional default array()
 *
 *	@return result array Output parameters for service execution [memory]
 *	@return valid boolean Service execution validity [memory]
 *	@return msg string Service execution result [memory]
 *	@return status integer Service execution status [memory]
 *	@return details string Service execution details [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class LaunchMessageService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('message'),
			'optional' => array('access' => array())
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		$memory['result'] = array();
		
		$message = $memory['message'];
		$access = $memory['access'];
		
		/**
		 *	Check for valid service request
		**/
		if(!isset($message['service'])){
			$memory['valid'] = false;
			$memory['msg'] = 'Invalid Message';
			$memory['status'] = 500;
			$memory['details'] = 'Please specify service to be executed with param service=root.service.operation (Only workflows may be launched)';
			return $memory;
		}
			
		/**
		 *	Get service URI and restrict access to services
		**/
		$uri = $message['service'];
		list($root, $service, $operation) = explode('.' ,$uri);
		$message['service'] = $uri = $uri.'.workflow';
		
		/**
		 *	Remove args if set (for being on safe side)
		**/
		if(isset($message['args'])) unset($message['args']);
		
		/**
		 *	Check for valid access for service requested
		**/
		if(!isset($access['root']) || (isset($access['root']) && !in_array($root, $access['root']))){
			$memory['valid'] = false;
			$memory['msg'] = 'Access Denied';
			$memory['status'] = 500;
			$memory['details'] = 'Access denied at root level';
			return $memory;
		}
		
		if(isset($access['service']) && !in_array($root.'.'.$service, $access['service'])){
			$memory['valid'] = false;
			$memory['msg'] = 'Access Denied';
			$memory['status'] = 500;
			$memory['details'] = 'Access denied at service level';
			return $memory;
		}
		
		if(isset($access['operation']) && !in_array($root.'.'.$service.'.'.$operation, $access['operation'])){
			$memory['valid'] = false;
			$memory['msg'] = 'Access Denied';
			$memory['status'] = 500;
			$memory['details'] = 'Access denied at operation level';
			return $memory;
		}
		
		/**
		 *	Run the service using WorkflowKernel
		**/
		unset($memory['msg']);
		$memory = $kernel->run($message, $memory);
		
		if(!$memory['valid']){
			return $memory;
		}
		
		/**
		 *	Read service output
		**/
		$service = Snowblozm::load($uri);
		foreach($service->output() as $key){
			$memory['result'][$key] = $memory[$key];
		}
		
		
		return $memory;
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('result', 'valid', 'msg', 'status', 'details');
	}
	
}

?>