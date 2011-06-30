<?php 

require_once(dirname(__FILE__).'/Component.interface.php');

/**
 *	@interface Operation
 *	@desc Abstract interface for operation
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
interface Operation extends Component {

	/**
	 *	@method getRequestService
	 *	@desc Get the request service
	 *
	 *	@return $rs RequestService
	 *
	**/
	public function getRequestService();
	
	/**
	 *	@method getResponseService
	 *	@desc Get the response service
	 *
	 *	@return $rs ResponseService
	 *
	**/
	public function getResponseService();
}

?>
