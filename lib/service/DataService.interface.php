<?php

// Abstract interface for Data services
interface DataService {

	// open connection to database
	public function open($database);
	
	// execute query and get result/result-set
	public function getResult($query, $execute, $resulttype);
	
	// escape parameter strings array
	public function escape($param);
	
	//gets the last auto-increment id
	public function getAutoId();
	
	//close the connection
	public function close();
	
	// get the error
	public function getError();
	
	//public function getStatement();
}

?>