<?php 

/**
 *	@class Snowblozm
 *	@desc Manages ServiceProvider mappings and helps in loading services and workflows
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
 **/
class Snowblozm {
	
	/** 
	 *	@static sparray array ServiceProvider Configuration array
	**/
	private static $sparray = array();
	
	/** 
	 *	@method add
	 *	@desc Adds a service provider definition array
	 *
	 *	@param spname string ServiceProvider name
	 *	@param spdef array (root, location, type, map, key)
	 *
	**/
	public static function add($spname, $spdef){
		self::$sparray[$spname] = $spdef;
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
