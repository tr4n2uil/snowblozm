<?php 
require_once('Parser.interface.php');

// Concrete parser for .ini formatted files
class IniParser implements Parser {

	// Flag defined whether the subsections will be taken into account while parsing
	protected $flag;
	
	// Constructor
	public function __construct($flag = true){
		$this->flag = $flag;
	}
	
	// Parser interface
	public function parse($file){
		return parse_ini_file($file, $this->flag);
	}
}

?>
