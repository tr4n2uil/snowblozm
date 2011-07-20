<?php 
require_once(SBSERVICE);

/**
 *	@class TimeGetService
 *	@desc Returns current time both timestamp and formatted
 *
 *	@param diff long int Time difference [message] optional default 0
 *
 *	@return timestamp long int Timestamp [memory]
 *	@return formatted string Formatted time [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class TimeGetService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$diff = isset($message['diff']) ? $message['diff'] : 0;
		
		$memory['timestamp'] = time() + $diff;
		$memory['formatted'] = date('c', $memory['timestamp']);
		
		/**
		 *	Save the request host address and proxy address if any
		**/
		if(isset($_SERVER['REMOTE_ADDR']))
			$memory['client'] = $_SERVER['REMOTE_ADDR'];
		if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			$memory['client'] .= " / ".$_SERVER["HTTP_X_FORWARDED_FOR"];
		
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Time Given';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>