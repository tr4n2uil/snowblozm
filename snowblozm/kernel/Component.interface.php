<?php 
require_once(dirname(__FILE__).'/Component.interface.php');

// Abstract interface for operations
interface Operation extends Component {

	// Get the context service
	public function getContextService();
	
	// Get the transform service
	public function getTransformService();
}

?>
