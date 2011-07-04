<?php 

/**
 *	@interface TransformService
 *	@desc Abstract interface for transform services 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
interface TransformService {

	/** 
	 *	@method transform
	 *	@desc transform model and returns it
	 *
	 *	@param $model object State
	 *
	 *	@return $model object
	 *
	**/
	public function transform($model);
}

?>
