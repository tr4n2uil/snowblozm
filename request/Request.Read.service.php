<?php 
require_once(SBSERVICE);

/**
 *	@class RequestReadService
 *	@desc Reads HTTP request parameters sent by GET POST JSON XML MEMORY WDDX
 *
 *	@param params array Request keys [message]
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
				$data = file_get_contents('php://input');
				$request = json_decode($data, true);
				break;
			case 'xml' :
				$data = file_get_contents('php://input');
				$request = $this->xml_decode($data);
				break;
			case 'wddx' :
				$data = file_get_contents('php://input');
				$request = wddx_deserialize($data);
				break;
			default :
				break;
		}
		
		$params = isset($message['params']) ? $message['params'] : array();

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
	
	public function xml_decode($data){
		$xmldata = (array) @simplexml_load_string($data);
		return $xmldata;
	}
	
}

?>