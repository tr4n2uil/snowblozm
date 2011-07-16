<?php 

	/**
	 * 	@root SnowBlozm
	**/
	define('SBROOT', dirname(__FILE__).'/' );

	/** 
	 *	@constants SnowBlozm v2 System
	**/
	define('SBCORE', SBROOT . 'libv2/core/Snowblozm.class.php');
	define('SBSERVICE', SBROOT . 'libv2/interface/Service.interface.php');
	define('SBWFKERNEL', SBROOT . 'libv2/kernel/WorkflowKernel.class.php');
	define('SBRMTWF', SBROOT . 'libv2/proxy/RemoteWorkflow.class.php');
	
	/** 
	 *	@constants SnowBlozm v2 Utility
	**/
	define('SBMYSQL', SBROOT . 'libv2/database/Mysql.class.php');
		
	/** 
	 *	@initialize SnowBlozm v2
	**/
	require_once(SBCORE);
	
	Snowblozm::add('sb', array(
		'root' => SBROOT.'workflow/',
		'location' => 'local'
	));
		
	Snowblozm::add('sbdemo', array(
		'root' => SBROOT.'demo/v2/',
		'location' => 'local'
	));
		
	Snowblozm::add('sbremote', array(
		'root' => 'http://localhost/iitbhucse/launch.php?uri=',
		'location' => 'remote',
		'type' => 'json',
		'map' => 'sbdemo',
		'key' => ''
	));
	
	/**
	 *	@dependency PHPMailer
	**/
	define('PHPMAILER', SBROOT.'../../libraries/phpmailer/PHPMailer.class.php');

		
	/** 
	 *	@constants SnowBlozm v1 System
	**/
	define('SBINTERFACES', SBROOT . 'lib/interfaces.php');
	define('SBKERNEL', SBROOT . 'lib/kernel/ServiceKernel.class.php');
	define('SBCOMLOADER', SBROOT . 'lib/loader/ComponentLoader.class.php');

	/** 
	 *	@constants SnowBlozm v1 Utility
	**/		
	//define('SBMYSQL', SBROOT . 'lib/database/Mysql.class.php');
	define('SBMAIL', SBROOT . 'lib/util/Mail.class.php');
	define('SBTIME', SBROOT . 'lib/util/Time.class.php');


?>
