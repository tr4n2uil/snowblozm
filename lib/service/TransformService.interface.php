<?php 

// Abstract interface for Transform service
interface TransformService {

	// Transform the model and context and return them
	public function transform($model);
}

?>
