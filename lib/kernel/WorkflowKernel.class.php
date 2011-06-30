<?php 

require_once(SBSERVICE);

/**
 *	@class WorkflowKernel
 *	@desc Provides core functionality of the enhanced kernel for executing service workflows
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class WorkflowKernel {
	
	/** 
	 *	@method run
	 *	@desc Runs a workflow by using its definition object with Service interface
	 *
	 *	@param $cmp Component
	 *	@param $model object
	 *
	 *	@return $model object
	 *
	**/
	public function run(Component $cmp, $model){
		$cs 	= 	$cmp->getContextService();
		$ts	= 	$cmp->getTransformService();
		
		/**
		 *	Set valid flag
		**/
		if(!isset($model['valid']))
			$model['valid'] = true;
		
		/**
		 *	Get context using ContextService
		**/
		if($model['valid'] === true)
			$model = $cs->getContext($model);
		
		/**
		 *	Transform using TransformService
		**/
		if($model['valid'] === true)
			$model = $ts->transform($model);
		
		/**
		 *	Set context using ContextService
		**/
		if($model['valid'] === true)
			$model = $cs->setContext($model);
		
		/**
		 *	Return $model
		**/
		return $model;
	}
	
}

?>
