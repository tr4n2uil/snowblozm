<?php 

require_once(SBINTERFACES);

/**
 *	@class ServiceKernel
 *	@desc Provides core functionality of the kernel
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ServiceKernel {
	
	/** 
	 *	@method start
	 *	@desc Start the kernel and run the service operation
	 *
	 *	@param $op Operation
	 *	@param $model object optional
	 *
	 *	@return $model object
	 *
	**/
	public function start(Operation $op, $model=null){
		$rqs 	= 	$op->getRequestService();
		$rps 	= 	$op->getResponseService();
		
		/**
		 *	Process request if $model is NULL else set valid flag
		**/
		if($model == null)
			$model	= $rqs->processRequest();
		else
			$model['valid'] = true;
		
		/**
		 *	Run the component part of the operation
		**/
		if($model['valid'] === true)
			$model = $this->run($op, $model);
		
		/**
		 *	Process response and return $model
		**/
		return $rps->processResponse($model);
	}
	
	/** 
	 *	@method run
	 *	@desc Run local component and return the result
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
