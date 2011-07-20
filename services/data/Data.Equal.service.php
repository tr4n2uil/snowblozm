<?php 
require_once(SBSERVICE);

/**
 *	@class DataEqualService
 *	@desc Checks for equality and gives error message as configured
 *
 *	@param data mixed Data to be checked [message|memory] optional default 1
 *	@param value mixed Value to check against [message|memory] optional default 1
 *	@param not boolean Is error on non-equalilty [message] optional default true
 *	@param errormsg string Error message [message]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class DataEqualService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'optional' => array('data' => 1, 'value' => 1)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$data = isset($message['data']) ? $message['data'] : $memory['data'];
		$value = isset($message['value']) ? $message['value'] : $memory['value'];
		$not = isset($message['not']) ? $message['not'] : true;
		$errormsg = $message['errormsg'];
		
		if($not ^ ($data == $value)){
			$memory['valid'] = false;
			$memory['msg'] = $errormsg;
			$memory['status'] = 505;
			$memory['details'] = 'Data not equal to value : '.$value.' @data.equal.service';
			return $memory;
		}

		$memory['valid'] = true;
		$memory['msg'] = 'Valid Equality Check';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array();
	}
	
}

?>