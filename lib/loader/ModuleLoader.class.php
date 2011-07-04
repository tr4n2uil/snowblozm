<?php 

require_once(SBROOT . 'lib/interface/Loader.interface.php');

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
		list($service, $operation, $type) = explode('.' ,$uri);
		
		$path = $root.$service.'/';
		
		$service = ucfirst($service);
		$operation = ucfirst($operation);
		
		$path = $path.$service.'.'.$operation.'.'.$type;
		$class = $service.$operation.ucfirst($type);
		
		require_once($path . '.php');
		return new $class;
	}
	
}

?>
