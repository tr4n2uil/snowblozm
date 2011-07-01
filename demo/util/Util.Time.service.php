<?php 
require_once(SBSERVICE);

class UtilTimeService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$memory['current-time'] = time();
		$memory['current-time-formatted'] = date("r");
		return $memory;
	}
	
}

?>