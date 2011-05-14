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
			$model		= 	$rqs->processRequest();
			
		$model = $this->run($op, $model);
		
		echo $rps->processResponse($model);
	}
	
	// Run local service and return the result
	public function run(Operation $op, $model){
		$cs 	= 	$op->getContextService();
		$ts	= 	$op->getTransformService();
		
		$model 	= 	$cs->getContext($model);
		$model 		= 	$ts->transform($model);
		$cs->setContext($model);
		
		return $model;
	}
}

?>
