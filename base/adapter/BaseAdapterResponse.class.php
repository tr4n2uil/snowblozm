<?php 

require_once(SBINTERFACES);

class BaseAdapterResponse implements ResponseService {
	
	// ResponseService interface
	public function processResponse($model){
		$view = "<h1>Hello World!</h1>";
		return $view;
	}
}

?>
