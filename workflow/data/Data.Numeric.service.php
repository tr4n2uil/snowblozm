<?php 
require_once(SBSERVICE);
require_once(SBMYSQL);

/**
 *	@class DataNumericService
 *	@desc Checks all values for being number
 *
 *	@param params array Array of numbers to check [message] optional default input
 *	@param errormsg string Error message [message] optional default 'Invalid Numeric Value'
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class DataNumericService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$params = isset($message['params']) ? $message['params'] : $message['input'];
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid Numeric Value';
		
		foreach($params as $key){
			if(!is_numeric($memory[$key])){
				$memory['valid'] = false;
				$memory['msg'] = $errormsg;
				$memory['status'] = 505;
				$memory['details'] = 'Value not numeric : '.$memory[$key].' @data.equal.service';
				return $memory;
			}
		}

		$memory['valid'] = true;
		$memory['msg'] = 'Valid Number Checks';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>