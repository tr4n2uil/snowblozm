<?php 

/**
 *	@interface DataService
 *	@desc Abstract interface for database services 
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
interface DataService {

	/** 
	 *	@method open
	 *	@desc open connection to data service
	 *
	 *	@param $databse string Database name
	 *	@param $user string Database user
	 *	@param $pass string Datanse password
	 *	@param $host string Database host
	 *
	**/
	public function open($database, $user, $pass, $host);
	
	/** 
	 *	@method getResult
	 *	@desc executes query and returns resultset if execute is false, else return affected row count
	 *
	 *	@param $query string SQL query
	 *	@param $execute boolean Is execute only
	 *	@param $resulttype MySQL constant
	 *
	 *	@return $result array/integer/false
	 *
	**/
	public function getResult($query, $execute=false, $resulttype=MYSQL_NUM);
	
	/** 
	 *	@method escape
	 *	@desc escapes parameter strings array
	 *
	 *	@param $param string
	 *
	 *	@return $result string
	 *
	**/
	public function escape($param);
	
	/** 
	 *	@method getAutoId
	 *	@desc gets the last auto-increment id
	 *
	 *	@return $result long int
	 *
	**/
	public function getAutoId();
	
	/** 
	 *	@method close
	 *	@desc closes the connection
	 *
	**/
	public function close();
	
	/** 
	 *	@method getError
	 *	@desc gets the last error
	 *
	 *	@return $result string Error information
	 *
	**/
	public function getError();
	
	//public function getStatement();
}

?>