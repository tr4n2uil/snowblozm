<?php 

require_once(SBINTERFACES);

class BaseAdapterResponse implements ResponseService {
	
	// ResponseService interface
	public function processResponse($model){
		return $model;
	}
}

?>
