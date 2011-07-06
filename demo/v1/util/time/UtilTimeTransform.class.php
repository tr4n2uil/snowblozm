<?php 

require_once(SBINTERFACES);

class UtilTimeTransform implements TransformService {

	// TransformService interface
	public function transform($model){
		$model['current-time'] = time();
		$model['current-time-formatted'] = date("r");
		return $model;
	}
}

?>
