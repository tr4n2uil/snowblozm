<?php 
require_once(SBWFKERNEL);

/**
 *	@class Snowblozm
 *	@desc Central class for management purposes
 *				Manages ServiceProvider configurations
 *				Manages Initialization configurations
 *				Manages loading and Services and Workflows
 *				Manages launching of Workflows
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
	
	/**
	 *	@method launch
	 *	@desc Launches workflows after decoding input and encodes response to output 
	 *
	 *	@condition crypt executed only if (user, message, challenge) value found in request
	 *	@condition hash executed only if (hash, message) value found in request
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
	 *						service : (service uri if request),
	 *						... params ...
	 *					}
	 *	
	 *	@param reqtype string request type ('get', 'post', 'json', 'wddx', 'xml')
	 *	@param restype string response types ('json', 'wddx', 'xml', 'plain', 'html'),
	 *	@param crypt string Crypt types ('none', 'rc4', 'aes', 'blowfish', 'tripledes')
	 *	@param hash string Hash types ('none', 'md5', 'sha1', 'crc32')
	 *	@param access array allowed service provider names
	 *	@param email string Identification email to be used if not set in message optional default false
	 *
	**/
	public static function launch($reqtype, $restype, $crypt, $hash, $access, $email = false){
		
		/**
		 *	WorkflowKernel instance and initialization
		**/
		$kernel = new WorkflowKernel();
		$memory = array(
			'restype' => $restype,
			'crypt' => $crypt,
			'hash' => $hash,
			'email' => $email
		);
		
		/**
		 *	Unsecure message
		**/
		$workflow = array(
		array(
			'service' => 'sbcore.request.read.service'
		),
		array(
			'service' => 'sb.secure.read.workflow',
			'type' => $reqtype
		));
		
		$memory = $kernel->execute($workflow, $memory);
		if(!$memory['valid']){
			self::respond($memory);
			exit;
		}
		
		$message = $memory['result'];
		
		/**
		 *	Check for valid service request
		**/
		if(!isset($message['service'])){
			echo "Please specify service to be executed with param service=root.service.operation (Only workflows may be launched)";
			exit;
		}
			
		/**
		 *	Get service URI and restrict access to services
		**/
		$uri = $message['service'];
		list($root, $service, $operation) = explode('.' ,$uri);
		$message['service'] = $uri = $uri.'.workflow';
		
		/**
		 *	Remove args if set (for being on safe side)
		**/
		if(isset($message['args'])) unset($message['args']);
		
		/**
		 *	Check for valid access for service requested
		**/
		if(!in_array($root, $access)){
			echo 'Access Denied';
			exit;
		}
		
		/**
		 *	Run the service using WorkflowKernel
		**/
		unset($memory['msg']);
		$memory = $kernel->run($message, $memory);
		
		if(!$memory['valid']){
			self::respond($memory);
			exit;
		}
		
		/**
		 *	Read service output
		**/
		$service = self::load($uri);
		$output = $service->output();
		
		/**
		 * Write response
		**/
		self::respond($memory, $output);
		
		return;
	}
	
	/**
	 *	@method respond
	 *	@desc Encodes response and writes it securely
	 *	
	 *	@param memory array Memory array
	 *	@param output array Output keys optional default array()
	 *
	**/
	private static function respond($memory, $output = array()){
	
		/**
		 *	WorkflowKernel instance and initialization
		**/
		$kernel = new WorkflowKernel();
		
		/**
		 *	Response workflow
		**/
		$workflow = array(
		array(
			'service' => 'sbcore.data.prepare.service',
			'args' => $output,
			'strict' => false
		),
		array(
			'service' => 'sb.secure.write.workflow',
			'input' => array('data' => 'result', 'type' => 'restype'),
			'valid' => $memory['valid'],
			'msg' => $memory['msg'],
			'status' => $memory['status'],
			'details' => $memory['details']
		),
		array(
			'service' => 'sbcore.response.write.service',
			'input' => array('data' => 'result')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>
