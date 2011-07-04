<?php 

require_once(SBROOT . 'lib/interface/Loader.interface.php');
require_once(SBREMOTE);

/**
 *	@class RemoteLoader
 *	@desc Loads remote service (module) and returns proxy
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
 **/
class RemoteLoader implements Loader {
	
	/** 
	 *	@interface Loader interface
	**/
	public function load($uri, $root){
		return new RemoteService($uri, $root);
	}
	
}

?>
