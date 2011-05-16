<?php 
require_once('Curl.class.php');

class Mail {
	private static $delegate, $value, $user, $pass, $from;
	
	public static function initialize($delegate, $value, $user="", $pass="", $from=""){
		self::$delegate = $delegate;
		self::$value = $value;
		self::$user = $user;
		self::$pass = $pass;
		self::$from = $from;
	}
	
	public static function send($to, $sub, $msg, $hdr){
		if(self::$delegate)
			return self::delegateto($to, $sub, $msg, $hdr);
		else
			return mail($to, $sub, $msg ,$hdr, self::$value);
	}
	
	private static function delegateto($to, $sub, $msg, $hdr) 
	{
        $params  = array(
            'to' => $to,
            'sub' => $sub,
            'msg' => $msg,
			'from' => self::$from,
			'smtpuser' => self::$user,
			'smtppass' => self::$pass
        );
		$curl = new Curl(self::$value, $params);
		return $curl->send();
	}

}

?>
