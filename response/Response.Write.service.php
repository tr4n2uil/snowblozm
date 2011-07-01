<?php 
require_once(SBSERVICE);

/**
 *	@class ResponseWriteService
 *	@desc Writes HTTP response in JSON XML HTML PLAIN MEMORY WDDX
 *
 *	@param params array Response keys [message]
 *	@param type string Request type [message] optional default 'json' ('json, 'xml', 'html', 'plain', 'memory', 'wddx')
 *	@param successmsg string Success message [message|memory] optional default 'Successfully Executed'
 *
 *	@return response values [echo]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class ResponseWriteService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$type = isset($message['type']) ? $message['type'] : 'json';
		
		$result = array();
		$default = array('valid' => 'valid', 'msg' => 'msg', 'status' => 'status', 'details' => 'details');
		$params = isset($message['params']) ? array_merge($default, $message['params']) : $default;
		$successmsg = isset($message['successmsg']) ? $message['successmsg'] : (isset($memory['successmsg']) ? $memory['successmsg'] : 'Successfully Executed');
		
		foreach($params as $key => $value){
			if(!isset($memory[$key])){
				continue;
			}
			$result[$value] = $memory[$key];
		}
		
		if($result['valid'])
			$result['msg'] = $successmsg;
		
		switch($type){
			case 'json' :
				echo json_encode($result);
				break;
			case 'xml' :
				echo $this->xml_encode($result);
				break;
			case 'memory' :
				$memory['result'] = $result;
				break;
			case 'html' :
				echo $this->html_encode($result);
				break;
			case 'wddx' :
				echo wddx_serialize_value($result);
				break;
			case 'plain' :
				echo var_dump($result);
				break;
			default :
				break;
		}

		$memory['valid'] = true;
		$memory['msg'] = 'Valid Response Given';
		$memory['status'] = 201;
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
	
	public function html_encode($data){
		return 'Not implemented yet';
	}
	
}

?>