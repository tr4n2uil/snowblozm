<?php 
require_once(SBSERVICE);

/**
 *	@class RequestReadService
 *	@desc Reads HTTP request parameters sent by GET POST JSON XML MEMORY WDDX into memory
 *
 *	@param type string Request type [message] optional default 'post' ('get, 'post', 'memory', 'json', 'xml', 'wddx')
 *
 *	@return request values [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class RequestReadService implements Service {
	
	/**
	 *	@var output array output keys
	**/
	private $output;
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array();
	}
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$type = isset($message['type']) ? $message['type'] : 'post';
		
		switch($type){
			case 'get' :
				$request = $_GET;
				break;
				
			case 'post' :
				$request = $_POST;
				break;
				
			case 'memory' :
				$request = $memory;
				break;
				
			case 'json' :
			case 'xml' :
			case 'wddx' :
				$kernel = new WorkflowKernel();
				$mdl = array(
					'service' => 'sbcore.data.decode.service',
					'data' => file_get_contents('php://input'),
					'type' => $type
				);
				$memory = $kernel->run($mdl, $memory);
				
				if(!$memory['valid'])
					return $memory;
				
				$request = $memory['result'];
				break;
				
			default :
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Request Data Type';
				$memory['status'] = 501;
				$memory['details'] = 'Request read not supported for type : '.$type.' @request.read.service';
				return $memory;
		}
		
		if(!isset($request['service'])){
			$memory['valid'] = false;
			$memory['msg'] = 'Invalid Request';
			$memory['status'] = 502;
			$memory['details'] = 'Service value not found @request.read.service';
			return $memory;
		}

		$this->output = array_keys($request);
		$memory = array_merge($memory, $request);
		
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Request';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array(
			'required' => $this->output,
			'optional' => array('key' => '0')
		);
	}
	
}

?>