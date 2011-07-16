<?php 
require_once(SBSERVICE);
require_once(PHPMAILER);

/**
 *	@class MailSmtpService
 *	@desc Sends HTML mail using PHPMailer SMTP functions
 *
 *	@param to string To address [message]
 *	@param subject string Subject [message] 
 *	@param message string Message [message] 
 *	@param mail array Mail configuration [memory] (type, host, port, secure, user, email, pass)
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *	
**/
class MailSmtpService implements Service {
	
	/**
	 *	@interface Service
	**/
	public function run($message, $memory){
		$mail = $memory['mail'];
		$to = $message['to'];
		$subject = $message['subject'];
		$message = $message['message'];
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = $mail['secure'];
		$mail->Host = $mail['host'];
		$mail->Port = $mail['port'];

		$mail->Username = $mail['email'];
		$mail->Password = $mail['pass'];

		$mail->AddReplyTo($mail['email'], $mail['user']);
		$mail->From = $mail['email'];
		$mail->FromName = $mail['user'];

		$mail->Subject = $subject;
		$mail->WordWrap = 50;
		$mail->MsgHTML($message);
		
		$rcpts = explode(',', $to);
		foreach($rcpts as $rcpt){
			$mail->AddAddress($rcpt, "");
		}

		//$mail->AddAttachment("images/phpmailer.gif");             // attachment
		$mail->IsHTML(true);

		if(!$mail->Send()) {
			$memory['result'] = false;
			$memory['msg'] = 'Error sending Mail';
			$memory['status'] = 503;
			$memory['details'] = 'Error : '.$mail->ErrorInfo.' @mail.smtp.service';
			return $memory;
		}
		
		$memory['valid'] = true;
		$memory['msg'] = 'Mail Accepted for Delivery';
		$memory['status'] = 200;
		$memory['details'] = 'Successfully executed';
		return $memory;
	}
	
}

?>