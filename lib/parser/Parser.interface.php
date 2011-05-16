<?php 

// Abstract interface for parsers
interface Parser {
	
	// Parses the file and return an array of properties/settings
	public function parse($file);
}

?>
