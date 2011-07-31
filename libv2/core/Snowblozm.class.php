<?php 
require_once(SBWFKERNEL);

/**
 *	@class Snowblozm
 *	@desc Central class for management purposes
 *				Manages ServiceProvider configurations
 *				Manages Initialization configurations
 *				Manages loading of Services and Workflows
 *
 *	@format 	request = {
 *						user : (email of key to use for crypt),
 *						challenge : (used to generate key for decrypting message),
 *						message : (all request values as array/object within this encrypted message),
 *						hash : (hash of message)
 *					}
 *
 *	@format	response = {
 *						valid : (valid execution flag),
 *						msg : (service execution message),
 *						status : (status code),
 *						details : (service execution details),
 *						message : (all response values as array/object within this encrypted message),
 *						hash : (hash of message)
 *					}
 *
 *	@format	message = {
 *						service : (service URI (root.service.operation)),
 *						... params ...
 *					}
 *	
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
 **/
class Snowblozm {
	
	/** 
	 *	@static sparray array ServiceProvider configurations
	**/
	private static $sparray = array();
	
	/** 
	 *	@static initarray array Initialization configurations
	**/
	private static $initarray = array();
	
	/** 
	 *	@static debug boolean Debug flag
	**/
	public static $debug = false;
	
	/** 
	 *	@static setmime string Set response MIME type
	**/
	public static $setmime = false;
	
	/** 
	 *	@method add
	 *	@desc Adds a service provider configuration
	 *
	 *	@param spname string ServiceProvider name
	 *	@param spconf array (root, location, type, map, key)
	 *
	**/
	public static function add($spname, $spconf){
		self::$sparray[$spname] = $spconf;
	}
	
	/** 
	 *	@method init
	 *	@desc Adds an initialization configuration
	 *
	 *	@param initname string Initialization name
	 *	@param initconf array 
	 *
	**/
	public static function init($initname, $initconf){
		self::$initarray[$initname] = $initconf;
	}
	
	/** 
	 *	@method get
	 *	@desc Gets an initialization configuration if exists
	 *
	 *	@param initname string Initialization name
	 *
	 *	@return initconf array 
	 *
	**/
	public static function get($initname){
		if(!isset(self::$initarray[$initname])){
			echo 'Initialization configuration not found for key : '.$initname;
			exit;
		}
		
		return self::$initarray[$initname];
	}
	
	/** 
	 *	@method load
	 *	@desc Loads local and remote services and workflows transparently
	 *
	 *	@param uri string Service / Workflow URI (sproot.service.operation.stype) (stype = service|workflow)
	 *
	**/
	public static function load($uri){
		list($sproot, $service, $operation, $stype) = explode('.' ,$uri);
		
		if(!isset(self::$sparray[$sproot])){
			echo 'Unable to identify Service Provider';
			exit;
		}
		
		$sp = self::$sparray[$sproot];
		$root = $sp['root'];
		$location = $sp['location'];
		
		switch($location){
			case 'local' :
				$path = $root.$service.'/';
				$service = ucfirst($service);
				$operation = ucfirst($operation);
				$class = $service.$operation.ucfirst($stype);
				require_once($path.$service.'.'.$operation.'.'.$stype.'.php');
				return new $class;
				
			case 'remote' :
				$type = $sp['type'];
				$key = $sp['key'];
				$map =$sp['map'];
				require_once(SBRMTWF);
				return new RemoteWorkflow($map.'.'.$service.'.'.$operation.'.'.$type, $root, $key);
			
			default :
				echo 'Unable to identify Service Provider location';
				exit;
		}
	}
	
}

?>
