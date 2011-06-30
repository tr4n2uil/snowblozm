<?php 

/**
 *	@interface ResponseService
 *	@desc Abstract interface for response services 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
interface ResponseService {

	/** 
	 *	@method processResponse
	 *	@desc processes model and echoes response
	 *
	 *	@param $model object State
	 *
	 *	@return $model object
	 *
	**/
	public function processResponse($model);
}

?>
