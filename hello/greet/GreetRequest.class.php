<?php 
require_once(dirname(__FILE__).'/../../snowblozm/interfaces.php');

class GreetRequest implements RequestService {
	
	// RequestService interface
	public function processRequest(){
		$array['name'] = $_GET['name'];
		return $array;
	}
}

?>
