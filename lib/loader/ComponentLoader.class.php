<?php 

require_once('Loader.interface.php');

class ComponentLoader implements Loader {
	
	// Loader interface
	public function load($uri, $root){
		$file = str_replace(".", "/", $uri);
		$operation =  ucfirst(substr(strrchr($uri, "."), 1));
		$ns = ucfirst(substr($uri, 0, strpos($uri, ".")));
		$operation = $ns.$operation;
		$file = $file . "/" . $operation . ".class.php";
		
		require_once($root . $file);
		return new $operation;
	}
}

?>
