<?php

	require_once('../init.php');
	require_once(SBCORE);
	
	if(!isset($_GET['type'])){
		echo "Please specify request.response.secure type using GET param type";
		exit;
	}
	
	$type = $_GET['type'];
	
	/**
	 *	Read request.response.secure.hash types
	**/
	list($reqtype, $restype, $crypt, $hash) = explode('.', $type);
	
	/**
	 *	Validate request type
	**/
	if(!in_array($reqtype, array('get', 'post', 'json', 'xml', 'wddx'))){
		echo 'Please check request type. '.$reqtype.' not supported';
		exit;
	}
	
	/**
	 *	Validate response type
	**/
	if(!in_array($restype, array('json', 'xml', 'wddx', 'plain', 'html'))){
		echo 'Please check response type. '.$restype.' not supported';
		exit;
	}
	
	/**
	 *	Validate crypt type
	**/
	if(!in_array($crypt, array('none', 'rc4', 'aes', 'blowfish', 'tripledes'))){
		echo 'Please check crypt type. '.$crypt.' not supported';
		exit;
	}
	
	/**
	 *	Validate hash type
	**/
	if(!in_array($hash, array('none', 'md5', 'sha1', 'crc32'))){
		echo 'Please check hash type. '.$hash.' not supported';
		exit;
	}
	
	//Snowblozm::$debug = true;
	Snowblozm::init('sbconn', array(
		'type' => 'mysql',
		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'krishna',
		'database' => 'snowblozm'
	));
	
	Snowblozm::launch($reqtype, $restype, $crypt, $hash, array('sbdemo', 'sb'));

?>