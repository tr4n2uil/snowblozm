<?php 

// snowblozm directory
		define('SBROOT', $_SERVER['DOCUMENT_ROOT'] . '/services/snowblozm/');
		
// system constants
		define('SBINTERFACES', SBROOT . 'lib/interfaces.php');
		define('SBKERNEL', SBROOT . 'lib/kernel/ServiceKernel.class.php');
		define('SBCOMLOADER', SBROOT . 'lib/loader/ComponentLoader.class.php');
		define('SBSERVPROXY', SBROOT . 'lib/proxy/ServiceProxy.class.php');
		define('SBMYSQL', SBROOT . 'lib/database/Mysql.class.php');

?>
