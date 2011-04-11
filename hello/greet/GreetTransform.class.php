<?php 
require_once(dirname(__FILE__).'/../../snowblozm/interfaces.php');

class GreetTransform implements TransformService {

	// TransformService interface
	public function transform($context, $model){
		return array($context, $model);
	}
}

?>
