<?php 

require_once(SBINTERFACES);

class UtilTimeResponse implements ResponseService {
	
	// ResponseService interface
	public function processResponse($model){
		$view = "<h1>Time :  ".$model['current-time']."</h1>";
		$view .= "<h2>".$model['current-time-formatted']."</h2>";
		echo $view;
		return $model;
	}
}

?>
