<?php 
require_once('Loader.interface.php');

class ClassLoader implements Loader {
	
	// Loader interface
	public function load($uri){
		$file = str_replace(".", "/", $uri);
		require_once($_SERVER["DOCUMENT_ROOT"] . $uri);
		
	}
}

?>
