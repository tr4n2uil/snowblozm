<?php 
require_once(SBSERVICE);

/**
 *	@class ResponseWriteService
 *	@desc Writes HTTP response in JSON XML HTML PLAIN MEMORY WDDX
 *
 *	@param type string Request type [message] optional default 'json' ('memory', 'json, 'xml', 'wddx', 'html', 'plain')
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
		
		$result = $memory;
		$successmsg = isset($message['successmsg']) ? $message['successmsg'] : (isset($memory['successmsg']) ? $memory['successmsg'] : 'Successfully Executed');

		if($result['valid'])
			$result['msg'] = $successmsg;
		
		switch($type){
			case 'json' :
			case 'xml' :
			case 'wddx' :
				$kernel = new WorkflowKernel();
				$mdl = array(
					'service' => 'sb.data.encode.service',
					'output' => array('result' => 'result'),
					'data' => $result,
					'type' => $type
				);
				$memory = $kernel->run($mdl, $memory);
				
				if(!$memory['valid']){
					echo $memory['details'];
				}
				
				echo $memory['result'];
				break;
				
			case 'memory' :
				$memory['result'] = $result;
				break;
				
			case 'html' :
				echo $this->html_encode($result);
				break;
				
			case 'plain' :
				echo var_dump($result);
				break;
				
			default :
				echo 'Please check response data type. '.$type.' not supported';
				break;
		}

		$memory['valid'] = true;
		$memory['msg'] = 'Valid Response Given';
		$memory['status'] = 201;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
	public function html_encode($data){
		return 'Not implemented yet';
	}
	
}

?>