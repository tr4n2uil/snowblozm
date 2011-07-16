<?php 
require_once(SBSERVICE);

/**
 *	@class RandomStringService
 *	@desc Generates random string with optionally provided length characterset
 *
 *	@param length integer String length [message] optional default 10
 *	@param charset string Character set [message] optional default 'qwert12yuiop34asdf56ghjkl78zxcv90bnm'
 *
 *	@return random string Result [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class RandomStringService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$length = isset($message['length']) ? $message['length'] : 10;
		$charset = isset($message['charset']) ? $message['charset'] : 'qwert12yuiop34asdf56ghjkl78zxcv90bnm';
		
		$result = '';
		$charsetlen = strlen($charset)-1;

		for($i = 0 ; $i < $len; $i++){
			$result .= $charset[ mt_rand(0,$charsetlen) ];
		}
	
		$memory['random'] = $result;
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Random String Generation';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>