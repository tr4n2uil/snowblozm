<?php 

require_once(SBINTERFACES);

// Provides core functionality of the kernel
class ServiceKernel {
	
	// Constructor
	public function __construct(){
	
	}
	
	// Configure the tasks
	public function configure(Operation $op){
	
	}
	
	// Start the kernel and supervise the proceedings
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
	
	// Run local service and return the result
	public function run(Operation $op, $model){
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
