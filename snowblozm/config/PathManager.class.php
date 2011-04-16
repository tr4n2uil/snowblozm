<?php 

class PathManager {
	
	// Setup constants for usage from configuration file paths.conf
	public static function setupConstants(){		
		
		// snoblozm directory
		define('SBROOT', $_SERVER['DOCUMENT_ROOT'] . '/services/');
		
		// system constants
		define('SBINTERFACES', SBROOT . 'snowblozm/interfaces.php');
		define('SBKERNEL', SBROOT . 'snowblozm/kernel/ServiceKernel.class.php');
		define('SBCOMLOADER', SBROOT . 'snowblozm/loader/ComponentLoader.class.php');
		define('SBSERVPROXY', SBROOT . 'snowblozm/proxy/ServiceProxy.class.php');
		define('SBMYSQL', SBROOT . 'snowblozm/database/Mysql.class.php');
		
		// user-defined constants
		define('ECROOT', $_SERVER['DOCUMENT_ROOT'] . '/projects/enhancse-core/');
	}
}

?>
