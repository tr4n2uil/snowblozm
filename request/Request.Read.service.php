<?php 
require_once(SBSERVICE);

/**
 *	@class RequestReadService
 *	@desc Reads HTTP request parameters sent by GET POST JSON XML MEMORY WDDX
 *
 *	@param params array Request keys [message] optional default output
 *	@param type string Request type [message] optional default 'post' ('get, 'post', 'json', 'xml', 'memory', 'wddx')
 *
 *	@return request values [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class RequestReadService implements Service {
	
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
					'service' => 'sb.data.decode.service',
					'output' => array('result' => 'result'),
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
		
		$params = isset($message['params']) ? $message['params'] : $message['output'];

		foreach($params as $param){
			if(!isset($request[$param])){
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Request';
				$memory['status'] = 501;
				$memory['details'] = 'Value not found for '.$param.' @request.read.service';
				return $memory;
			}
			$memory[$param] = $request[$param];
		}
		
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Request';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>