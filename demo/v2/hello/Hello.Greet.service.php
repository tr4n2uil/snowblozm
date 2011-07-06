<?php 
require_once(SBSERVICE);

/**
 *	@class HelloGreetService
 *	@desc Greets hello world message (for demo)
 *
 *	@param name string Name [memory] optional default 'SnowBlozm'
 *
 *	@return view string Greet message [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class HelloGreetService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		if(!isset($memory['name'])){
			$memory['name'] = 'SnowBlozm';
		}
		
		$memory['view'] = 'Hello World from '.$memory['name'];
		
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Execution';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>