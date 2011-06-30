<?php 
require_once(SBSERVICE);

class UtilTime implements Service {
	
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