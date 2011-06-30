<?php 

require_once('Loader.interface.php');

/**
 *	@class ModuleLoader
 *	@desc Loads local service (module) and returns instance
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
 **/
class ModuleLoader implements Loader {
	
	/** 
	 *	@interface Loader interface
	**/
	public function load($uri, $root){
		list($service, $operation) = explode('.' ,$uri);
		
		$service = ucfirst($service);
		$operation = ucfirst($operation);
		
		$path = $root.$service.'.'.$operation;
		$class = $service.$operation;
		
		require_once($path . '.service.php');
		return new $class;
	}
	
}

?>
