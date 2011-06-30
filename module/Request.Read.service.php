<?php 
require_once(SBSERVICE);

/**
 *	@class RequestRead
 *	@desc Reads HTTP request parameters sent by GET or POST
 *
 *	@param $params array Request keys [message]
 *	@param $type string Request type [message] optional default 'post' ('get, 'post')
 *
 *	@return request values [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class RequestRead implements Service {
	
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
			default :
				break;
		}
		
		$params = isset($message['params']) ? $message['params'] : array();

		foreach($params as $param){
			if(!isset($request[$param])){
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Request';
				$memory['status'] = 501;
				$memory['details'] = 'Value not found for '.$param;
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