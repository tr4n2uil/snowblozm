<?php 

require_once(SBINTERFACES);

class HelloGreetRequest implements RequestService {
	
	// RequestService interface
	public function processRequest(){
		$array['name'] = $_GET['name'];
		return $array;
	}
}

?>
