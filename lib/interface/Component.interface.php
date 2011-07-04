<?php 

/**
 *	@interface Component
 *	@desc Abstract interface for component
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
interface Component {

	/**
	 *	@method getContextService
	 *	@desc Get the context service
	 *
	 *	@return $cs ContextService
	 *
	**/
	public function getContextService();
	
	/**
	 *	@method getTransformService
	 *	@desc Get the transform service
	 *
	 *	@return $ts TransformService
	 *
	**/
	public function getTransformService();
}

?>
