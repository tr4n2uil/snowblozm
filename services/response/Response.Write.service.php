<?php 
require_once(SBSERVICE);

/**
 *	@class ResponseWriteService
 *	@desc Writes HTTP response to output stream
 *
 *	@param data string Stream data [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class ResponseWriteService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('data')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		echo $memory['data'];

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
		return array();
	}
	
}

?>