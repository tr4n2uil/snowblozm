<?php 

/**
 *	@interface ContextService
 *	@desc Abstract interface for context services 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
interface ContextService {

	/** 
	 *	@method getContext
	 *	@desc generates the context from model
	 *
	 *	@param $model object State
	 *
	 *	@return $model object
	 *
	**/
	public function getContext($model);
	
	/** 
	 *	@method setContext
	 *	@desc saves the context from model
	 *
	 *	@param $model object State
	 *
	 *	@return $model object
	 *
	**/
	public function setContext($context);
}

?>
