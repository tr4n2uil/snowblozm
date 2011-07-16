<?php 
require_once(SBSERVICE);

/**
 *	@class DataEncodeService
 *	@desc Encodes array into JSON XML WDDX data
 *
 *	@param type string Request type [message] optional default 'json' ('json, 'xml', 'wddx')
 *	@param data array Data to be encoded [message|memory]
 *
 *	@return result string Encoded data [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class DataEncodeService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$type = isset($message['type']) ? $message['type'] : 'json';
		$data = isset($message['data']) ? $message['data'] : $memory['data'];
		
		switch($type){
			case 'json' :
				$result = json_encode($data);
				break;
			case 'xml' :
				$result = $this->xml_encode($data);
				break;
			case 'wddx' :
				$result = wddx_serialize_value($data);
				break;
			default :
				$memory['valid'] = false;
				$memory['msg'] = 'Invalid Data Type';
				$memory['status'] = 501;
				$memory['details'] = 'Data encoding not supported for type : '.$type.' @data.encode.service';
				return $memory;
		}
		
		if($result === false || $result == null){
			$memory['result'] = array();
			$memory['valid'] = false;
			$memory['msg'] = 'Invalid Data';
			$memory['status'] = 501;
			$memory['details'] = 'Data could not be encoded @data.encode.service';
			return $memory;
		}

		$memory['result'] = $result;
		$memory['valid'] = true;
		$memory['msg'] = 'Valid Data';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
	public function xml_encode($data){
		$xml = new XmlWriter();
		$xml->openMemory();
		$xml->startDocument('1.0', 'UTF-8');
		$xml->startElement('root');
		
		@$this->write($xml, $data);

		$xml->endElement();
		$xml->endDocument();
		return $xml->outputMemory(true);
	}
	
	private function write(XMLWriter $xml, $data){
		foreach($data as $key => $value){
			if(is_array($value)){
				$xml->startElement($key);
				@$this->write($xml, $value);
				$xml->endElement();
				continue;
			}
			$xml->writeElement($key, $value);
		}
	} 
	
}

?>