<?php 
require_once(SBSERVICE);
require_once(SBMYSQL);

/**
 *	@class DataSelectService
 *	@desc Selects data from deeper arrays into memory
 *
 *	@param params array Array indicating data to be selected [message] optional default array()
 *	@param errormsg string Error message [message] optional default 'Invalid Data Selection'
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class DataSelectService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$params = isset($message['params']) ? $message['params'] : array();
		$errormsg = isset($message['errormsg']) ? $message['errormsg'] : 'Invalid Data Selection';
		
		foreach($params as $key => $value){
			$tokens = explode('.', $key);
			$result = $memory;
			$len=count($tokens);
			
			for($i=0; $i<$len; $i++){
				if(!isset($result[$tokens[$i]])){
					$memory['valid'] = false;
					$memory['msg'] = $errormsg;
					$memory['status'] = 505;
					$memory['details'] = 'Value not found for token : '.$tokens[$i].' @data.select.service';
					return $memory;
				}
				$result = $result[$tokens[$i]];
			}
			
			$memory[$value] = $result;
		}

		$memory['valid'] = true;
		$memory['msg'] = 'Valid Data Selection';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>