<?php 

require_once(dirname(__FILE__).'/Component.interface.php');

// Abstract interface for operations
interface Operation extends Component {

	// Get the request service
	public function getRequestService();
	
	// Get the response service
	public function getResponseService();
}

?>
