<?php 

require_once(SBINTERFACES);

class HelloGreetResponse implements ResponseService {
	
	// ResponseService interface
	public function processResponse($model){
		$view = "<h1>Hello World ".$model['name']."</h1>";
		return $view;
	}
}

?>
