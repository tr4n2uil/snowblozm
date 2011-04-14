<?php 
require_once('../../init.php');
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
	public function start(Operation $op){
		$rqs 	= 	$op->getRequestService();
		$cs 	= 	$op->getContextService();
		$ts	= 	$op->getTransformService();
		$rps 	= 	$op->getResponseService();
		
		$model		= 	$rqs->processRequest();
		$context 	= 	$cs->getContext($model);
		
		$result 		= 	$ts->transform($context, $model);
		$context 	= 	$result[0];
		$model 	= 	$result[1];
		
		$cs->setContext($context);
		echo $rps->processResponse($model);
	}
}

?>
