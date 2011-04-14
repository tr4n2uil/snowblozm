<?php 
require_once('Loader.interface.php');

class ComponentLoader implements Loader {
	
	// Loader interface
	public function load($uri, $root){
		$file = str_replace(".", "/", $uri);
		$operation =  ucfirst(substr(strrchr($uri, "."), 1));
		$file = $file . "/" . $operation . ".class.php";
		
		require_once($root . $file);
		$class = new ReflectionClass($operation);
		
		return $class->newInstance();
	}
}

?>
