<?php 
require_once('../../init.php');
require_once(SBROOT . 'service/DataService.interface.php');

// Concrete MySQL implementation for Data services interface
class Mysql implements DataService {
	protected 
		// connection resource
		$conn;
	
	// Constructor
	public function __construct($database){
		$this->open($database);
	}

	// DataService interface : should be private
	public function open($database){
		// TODO Implement the credentials in ini file
		$this->conn = @mysql_connect('localhost', 'root', 'krishna');
		if( $this->conn==false ) {
			$err = mysql_errno();
			if( $err==1203 ) {
				die('Our database server is overcome with connections. Please try after some time.');
			}
			die('Could not connect to database host');
		}
		@mysql_select_db('codefest', $this->conn)
			or die('Could not select database');
	}
	
	// DataService interface
	public function getResult($query, $resulttype=MYSQL_NUM){
		$resultset = @mysql_query($q, $this->conn);
		$result = array();
		while( $rowset = mysql_fetch_array($resultset, $resulttype) ) {
			array_push( $result, $rowset );
		}
		return $result;
	}
	
	// DataService interface
	public function escape($param, $addslashes=false){
		foreach($param as $f){
			if( $addslashes==false ) {
				if( get_magic_quotes_gpc() ) $f = stripslashes($f);
			} else {
				if( !get_magic_quotes_gpc() ) $f = addslashes($f);
			}
			$f = mysql_real_escape_string($f, $this->conn);
		}
		return $param;
	}
	
	// DataService interface
	public function getAutoId(){
		return mysql_insert_id($this->conn);
	}
	
	// DataService interface
	public function close(){
		return mysql_close($this->conn);
	}
	
	// DataService interface
	public function getError(){
		return mysql_error($this->conn);
	}
	
	//public function getStatement();
}

?>