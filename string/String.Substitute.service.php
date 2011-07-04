<?php 
require_once(SBSERVICE);

/**
 *	@class StringSubstituteService
 *	@desc Substitutes ${key} in base string with value from memory for all keys in params array
 *
 *	@param params array Array of key to use for substitutions [message]
 *	@param basestr string Base string to use for substitutions [message]
 *
 *	@return result string String with substitutions done [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class StringSubstituteService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$basestr = $message['basestr'];
		$params = isset($message['params']) ? $message['params'] : array();
		
		foreach($params as $key){
			if(!isset($memory[$key])){
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Service State';
				$memory['status'] = 504;
				$memory['details'] = 'Value not found for '.$key.' @string.substitute.service';
				return $memory;
			}
			$result = str_replace('${'.$key.'}', $memory[$key], $basestr);
		}

		$memory['result'] = $result;
		$memory['valid'] = true;
		$memory['msg'] = 'Valid String Substitution';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>