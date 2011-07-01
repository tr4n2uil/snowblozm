<?php 
require_once(SBSERVICE);
require_once(SBMYSQL);

/**
 *	@class QueryEscapeService
 *	@desc Escapes all strings in the array
 *
 *	@param params array Array of strings to escape [message]
 *	@param conn resource DataService instance [memory]
 *
 *	@return result values as 'safe'.$key [memory]
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
		$params = isset($message['params']) ? $message['params'] : array();
		
		foreach($params as $key){
			if(!isset($memory[$key])){
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Workflow State';
				$memory['status'] = 503;
				$memory['details'] = 'Value not found for '.$key.' @query.escape.service';
				return $memory;
			}
			$memory['safe'.$key] = $conn->escape($memory[$key]);
		}

		$memory['valid'] = true;
		$memory['msg'] = 'Valid Execution';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>