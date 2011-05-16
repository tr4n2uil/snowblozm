<?php 

// snowblozm directory
		define('SBROOT', dirname(__FILE__).'/' );
		
// system constants
		define('SBINTERFACES', SBROOT . 'lib/interfaces.php');
		define('SBKERNEL', SBROOT . 'lib/kernel/ServiceKernel.class.php');
		define('SBCOMLOADER', SBROOT . 'lib/loader/ComponentLoader.class.php');
		define('SBSERVPROXY', SBROOT . 'lib/proxy/ServiceProxy.class.php');
		define('SBMYSQL', SBROOT . 'lib/database/Mysql.class.php');
		define('SBMAIL', SBROOT . 'lib/util/Mail.class.php');
		define('SBTIME', SBROOT . 'lib/util/Time.class.php');

?>
