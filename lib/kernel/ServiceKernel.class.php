<?php 

require_once(SBINTERFACES);

/**
 *	@class ServiceKernel
 *
 *	@desc Provides core functionality of the kernel
**/
class ServiceKernel {
	
	/** 
	 *	Start the kernel and run the service operation
	**/
	public function start(Operation $op, $model=null){
		$rqs 	= 	$op->getRequestService();
		$rps 	= 	$op->getResponseService();
		
		if($model == null)
			$model	= $rqs->processRequest();
		else
			$model['valid'] = true;
		
		if($model['valid'] === true)
			$model = $this->run($op, $model);
		
		return $rps->processResponse($model);
	}
	
	/** 
	 *	Run local component and return the result
	**/
	public function run(Component $op, $model){
		$cs 	= 	$op->getContextService();
		$ts	= 	$op->getTransformService();
		
		$model['valid'] = true;
		$model = $cs->getContext($model);
		
		if($model['valid'] === true)
			$model = $ts->transform($model);
		
		if($model['valid'] === true)
			$model = $cs->setContext($model);
		
		return $model;
	}
}

?>
