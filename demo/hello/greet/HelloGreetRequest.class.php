<?php 

require_once(SBINTERFACES);

class HelloGreetRequest implements RequestService {
	
	// RequestService interface
	public function processRequest(){
		$model['name'] = $_GET['name'];
		$model['valid'] = true;
		return $model;
	}
}

?>
