<?php

	require_once('../init.php');
	require_once(SBCORE);
	
	if(!isset($_GET['type'])){
		echo "Please specify request.response.secure type using GET param type";
		exit;
	}
	
	$type = $_GET['type'];
	
	//Snowblozm::$debug = true;
	Snowblozm::init('sbconn', array(
		'type' => 'mysql',
		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'krishna',
		'database' => 'snowblozm'
	));
	
	Snowblozm::launch($type, array('sbdemo', 'sb'));

?>