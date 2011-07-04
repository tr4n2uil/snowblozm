<?php 

require_once(SBROOT . 'lib/interface/Loader.interface.php');

/**
 *	@class ComponentLoader
 *	@desc Loads local component and returns instance
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
 **/
class ComponentLoader implements Loader {
	
	/** 
	 *	@interface Loader interface
	**/
	public function load($uri, $root){
		list($service, $operation) = explode('.' ,$uri);
		
		$path = $root.$service.'/'.$operation.'/';
		$class = ucfirst($service).ucfirst($operation);
		
		require_once($path . $class . '.class.php');
		return new $class;
	}
	
}

?>
