<?php 
require_once(SBSERVICE);

/**
 *	@class ValueEqualService
 *	@desc Checks for equality and gives error message as configured
 *
 *	@param key string Key to value in memory [message]
 *	@param value string Value to check [message]
 *	@param not boolean Is error on non-equalilty [message] optional default true
 *	@param errormsg string Error message [message]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class ValueEqualService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$key = $message['key'];
		$value = $message['value'];
		$not = isset($message['not']) ? $message['not'] : true;
		$errormsg = $message['errormsg'];
		
		if($not ^ ($memory[$key] == $value)){
			$memory['valid'] = false;
			$memory['msg'] = $errormsg;
			$memory['status'] = 505;
			$memory['details'] = 'Value not equal to '.$value.' @value.equal.service';
			return $memory;
		}

		$memory['valid'] = true;
		$memory['msg'] = 'Valid Equality Check';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>