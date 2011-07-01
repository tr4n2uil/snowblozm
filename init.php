<?php 

/**
 * 	snowblozm directory
**/
		define('SBROOT', dirname(__FILE__).'/' );

/** 
 *	utility constants
**/
		define('SBMYSQL', SBROOT . 'lib/database/Mysql.class.php');
		define('SBMAIL', SBROOT . 'lib/util/Mail.class.php');
		define('SBTIME', SBROOT . 'lib/util/Time.class.php');
		
/** 
 *	initial (v1) system constants
**/
		define('SBINTERFACES', SBROOT . 'lib/interfaces.php');
		define('SBKERNEL', SBROOT . 'lib/kernel/ServiceKernel.class.php');
		define('SBCOMLOADER', SBROOT . 'lib/loader/ComponentLoader.class.php');

/** 
 *	enhanced (v2) stystem constants
**/
		define('SBSERVICE', SBROOT . 'lib/kernel/Service.interface.php');
		define('SBWFKERNEL', SBROOT . 'lib/kernel/WorkflowKernel.class.php');
		define('SBMDLLOADER', SBROOT . 'lib/loader/ModuleLoader.class.php');

?>
