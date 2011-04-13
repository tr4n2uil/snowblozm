<?php 
require_once(dirname(__FILE__).'/../../snowblozm/interfaces.php');

class AdapterResponse implements ResponseService {
	
	// ResponseService interface
	public function processResponse($model){
		$view = "<h1>Hello World!</h1>";
		return $view;
	}
}

?>
