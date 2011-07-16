<?php 
require_once(SBSERVICE);

/**
 *	@class MailSendService
 *	@desc Sends mail using mail() function
 *
 *	@param to string To address [message]
 *	@param from string From address [message] optional default ''
 *	@param subject string Subject [message] 
 *	@param message string Message [message] 
 *	@param headers string Additional headers [message] optional default 'From: '.$from.'\r\nReply-To: '.$from.'\r\nX-Mailer: PHP/'.phpversion()
 *	@param params string Additional parameters [message] optional default ''
 *
 *	@return result boolean Return value [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class MailSendService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$to = $message['to'];
		$from = isset($message['from']) ? $message['from'] : '';
		$subject = $message['subject'];
		$message = $message['message'];
		$headers = isset($message['headers']) ? $message['headers'] : 'From: '.$from.'\r\nReply-To: '.$from.'\r\nX-Mailer: PHP/'.phpversion();
		$params = isset($message['params']) ? $message['params'] : '';
		
		$memory['result'] = mail($to, $subject, $message, $headers, $params);
		
		$memory['valid'] = true;
		$memory['msg'] = 'Mail Accepted for Delivery';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>