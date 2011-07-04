<?php 

/**
 *	@interface RequestService
 *	@desc Abstract interface for request services 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
interface RequestService {

	/** 
	 *	@method processRequest
	 *	@desc processes request and return model
	 *
	 *	@return $model object
	 *
	**/
	public function processRequest();
}

?>
