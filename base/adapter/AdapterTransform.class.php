<?php 
require_once(SBINTERFACES);

class AdapterTransform implements TransformService {

	// TransformService interface
	public function transform($model){
		return $model;
	}
}

?>
