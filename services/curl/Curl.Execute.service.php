<?php 
require_once(SBSERVICE);
require_once(SBMYSQL);

/**
 *	@class CurlExecuteService
 *	@desc Executes cURL request and returns response
 *
 *	@param url string URL [message|memory]
 *	@param data array/string Data to send with request [message|memory] optional default memory
 *	@param plain boolean [message] optional default false
 *
 *	@return response string Response [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class CurlExecuteService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'optional' => array('url' => '','data' => '')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$url = isset($message['url']) ? $message['url'] : $memory['url'];
		$data = isset($message['data']) ? $message['data'] : (isset($memory['data']) ? $memory['data'] : $memory);
		$plain = isset($message['plain']) ? $message['plain'] : false;
		
		if(isset($data['data'])) unset($data['data']);
		if(isset($data['url'])) unset($data['url']);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		if($plain)
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain')); 
			
		$result = curl_exec ($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		
		if ($result === false || $info['http_code'] != 200){
			$memory['valid'] = false;
			$memory['msg'] = 'Error in cURL';
			$memory['status'] = $info['http_code'];
			$memory['details'] = 'Curl error : '.curl_error($ch).' @curl.execute.service';
			return $memory;
		}

		$memory['response'] = $result;
		$memory['valid'] = true;
		$memory['msg'] = 'Valid cURL Execution';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('response');
	}
	
}

?>