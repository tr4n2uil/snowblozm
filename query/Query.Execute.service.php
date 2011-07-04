<?php 
require_once(SBSERVICE);
require_once(SBMYSQL);

/**
 *	@class QueryExecuteService
 *	@desc Executes a query and returns result set if flag is true and returns affected row count
 *
 *	@param query string SQL Query [message|memory]
 *	@param flag boolean Is result set unexpected [message] optional default false
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
		$flag = isset($message['flag']) ? $message['flag'] : false;
		
		$result = $conn->getResult($query, $flag);
		if($result === false){
			$memory['valid'] = false;
			$memory['msg'] = 'Error in Database';
			$memory['status'] = 503;
			$memory['details'] = 'Error : '.$conn->getError().' @query.execute.service';
			return $memory;
		}
		
		if($flag){
			$memory['sqlresult'] = $result;
			$memory['sqlrowcount'] = $result;
		}
		else {
			$memory['sqlresult'] = $result;
			$memory['sqlrowcount'] = count($result);
		}
		
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Query Execution';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>