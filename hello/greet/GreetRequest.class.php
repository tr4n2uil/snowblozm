<?php 
require_once(SBINTERFACES);

class GreetRequest implements RequestService {
	
	// RequestService interface
	public function processRequest(){
		$array['name'] = $_GET['name'];
		return $array;
	}
}

?>
