<?php 

require_once(SBINTERFACES);

class BaseAdapterTransform implements TransformService {

	// TransformService interface
	public function transform($model){
		return $model;
	}
}

?>
