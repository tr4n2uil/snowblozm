<?php 
require_once(SBSERVICE);

/**
 *	@class RandomNumberService
 *	@desc Generates random number between optionally provided limits
 *
 *	@param min integer Minimum limit [message] optional
 *	@param max integer Maximum limit [message] optional
 *
 *	@return random integer Result [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class RandomNumberService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		if(isset($message['min']) && isset($message['max'])){
			$memory['random'] = mt_rand($message['min'], $message['max']);
		}
		else {
			$memory['random'] = mt_rand();
		}
	
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Random Number Generation';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>