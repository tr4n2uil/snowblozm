<?php 
require_once(dirname(__FILE__).'/../../snowblozm/interfaces.php');

class GreetResponse implements ResponseService {
	
	// ResponseService interface
	public function processResponse($model){
		$view = "<h1>Hello World ".$model['name']."</h1>";
		return $view;
	}
}

?>
