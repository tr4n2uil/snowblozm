<?php 
require_once(SBSERVICE);

/**
 *	@class MailSendService
 *	@desc Sends mail using mail() function
 *
 *	@param to string To address [message]
 *	@param subject string Subject [message] 
 *	@param message string Message [message] 
 *	@param headers string Additional headers [message] optional default 'From: '.$mail['user'].' <'.$mail['email'].'>\r\nReply-To: '.$mail['user'].' <'.$mail['email'].'>\r\nX-Mailer: PHP/'.phpversion()
 *	@param params string Additional parameters [message] optional default ''
 *	@param mail array Mail configuration [memory] (type, host, port, secure, user, email, pass)
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
		$subject = $message['subject'];
		$message = $message['message'];
		$headers = isset($message['headers']) ? $message['headers'] : 'From: '.$mail['user'].' <'.$mail['email'].'>\r\nReply-To: '.$mail['user'].' <'.$mail['email'].'>\r\nX-Mailer: PHP/'.phpversion();
		$params = isset($message['params']) ? $message['params'] : '';
		
		if(!mail($to, $subject, $message, $headers, $params)){
			$memory['valid'] = false;
			$memory['msg'] = 'Error sending Mail';
			$memory['status'] = 503;
			$memory['details'] = 'Error : mail() returned false @mail.send.service';
			return $meory;
		}
		
		$memory['valid'] = true;
		$memory['msg'] = 'Mail Accepted for Delivery';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>