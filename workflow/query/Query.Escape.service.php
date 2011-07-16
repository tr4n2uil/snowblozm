<?php 
require_once(SBSERVICE);
require_once(SBMYSQL);

/**
 *	@class QueryEscapeService
 *	@desc Escapes all strings in the array
 *
 *	@param params array Array of strings to escape [message] optional default input-'conn'
 *	@param conn resource DataService instance [memory]
 *
 *	@return result values as param itself [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class QueryEscapeService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$conn = $memory['conn'];
		$params = isset($message['params']) ? $message['params'] : $message['input'];
		
		if(isset($params['conn']))
			unset($params['conn']);
		
		foreach($params as $key){
			$memory[$key] = $conn->escape($memory[$key]);
		}

		$memory['valid'] = true;
		$memory['msg'] = 'Valid Escapes';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>