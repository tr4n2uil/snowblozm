<?php 

/**
 *	@interface Loader
 *	@desc Abstract interface for loaders
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
interface Loader {

	/** 
	 *	@method load
	 *	@desc loads the component/operation/service and returns proxy
	 *
	 *	@param $uri string Service/Operation/Component URI
	 *	@param $memory object State management in workflows
	 *
	 *	@return $obj object Loaded component/operation/service
	 *
	**/
	public function load($uri, $root);
}

?>
