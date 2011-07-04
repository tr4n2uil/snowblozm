<?php 
require_once(SBSERVICE);

/**
 *	@class DataDecodeService
 *	@desc Decodes JSON XML WDDX data into array
 *
 *	@param type string Request type [message] optional default 'json' ('json', 'xml', 'wddx')
 *	@param data string Data to be decoded [message|memory]
 *
 *	@return result array Decoded data [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class DataDecodeService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$type = isset($message['type']) ? $message['type'] : 'json';
		$data = isset($message['data']) ? $message['data'] : $memory['data'];
		
		switch($type){
			case 'json' :
				$result = json_decode($data, true);
				break;
			case 'xml' :
				$result = (array) @simplexml_load_string($data);
				break;
			case 'wddx' :
				$result = wddx_deserialize($data);
				break;
			default :
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Data Type';
				$memory['status'] = 501;
				$memory['details'] = 'Data decoding not supported for type : '.$type.' @data.decode.service';
				return $memory;
		}

		if($result === false || $result == null){
			$memory['result'] = array();
			$memory['valid'] = false;
			$memory['msg'] = 'Invalid Data';
			$memory['status'] = 501;
			$memory['details'] = 'Data could not be decoded : '.$data.' @data.decode.service';
			return $memory;
		}
		
		$memory['result'] = $result;
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Data';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>