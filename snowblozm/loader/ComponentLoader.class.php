<?php 
require_once('Loader.interface.php');

class ComponentLoader implements Loader {
	
	// Loader interface
	public function load($uri){
		$file = str_replace(".", "/", $uri);
		$operation =  ucfirst(substr(strrchr($uri, "."), 1));
		$file = $file . "/" . $operation . ".class.php";
		
		require_once($_SERVER["DOCUMENT_ROOT"] . "/" . $file);
		$class = new ReflectionClass($operation);
		
		return $class->newInstance();
	}
}

?>
