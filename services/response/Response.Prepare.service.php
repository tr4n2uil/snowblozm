<?php 
require_once(SBSERVICE);

/**
 *	@class ResponsePrepareService
 *	@desc Writes HTTP response to output stream
 *
 *	@param data string Stream data [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class ResponsePrepareService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array();
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$result = $memory;
		if(isset($result['service'])) unset($result['service']);
		
		$memory['result'] = $result;
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Response Given';
		$memory['status'] = 201;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('result');
	}
	
}

?>