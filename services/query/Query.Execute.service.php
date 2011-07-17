<?php 
require_once(SBSERVICE);
require_once(SBMYSQL);

/**
 *	@class QueryExecuteService
 *	@desc Executes a query and returns result according to rstype
 *
 *	@param query string SQL Query [message|memory]
 *	@param rstype integer type of result [message] optional default 0
 *	@param conn resource DataService instance [memory]
 *
 *	@return sqlresult array SQL Query ResultSet [memory]
 *	@return sqlrowcount integer resultset or affected row count [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class QueryExecuteService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$conn = $memory['conn'];
		$query = isset($message['query']) ? $message['query'] : $memory['query'];
		$rstype = isset($message['rstype']) ? $message['rstype'] : 0;
		
		$result = $conn->getResult($query, $rstype);
		
		if($result === false){
			$memory['valid'] = false;
			$memory['msg'] = 'Error in Database';
			$memory['status'] = 503;
			$memory['details'] = 'Error : '.$conn->getError().' @query.execute.service';
			return $memory;
		}
		
		switch($rstype){
			case 0 :
				$memory['sqlresult'] = $result;
				$memory['sqlrowcount'] = count($result);
				break;
			case 1 :
				$memory['sqlresult'] = $result;
				$memory['sqlrowcount'] = $result;
				break;
			case 2 :
				$memory['sqlresult'] = $result;
				$memory['sqlrowcount'] = 1;
				break;
			default :
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Result Type';
				$memory['status'] = 503;
				$memory['details'] = 'Result type : '.$rstype.' not supported @query.execute.service';
				return $memory;
		}
		
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Query Execution';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>