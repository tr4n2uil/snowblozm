<?php

// Abstract interface for loaders
interface Loader {

	// Loads the resource from uri as proxy
	public function load($uri);
}

?>
