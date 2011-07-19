<?php 
require_once(SBWFKERNEL);

/**
 *	@class Snowblozm
 *	@desc Central class for management purposes
 *				Manages ServiceProvider configurations
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
	 *	@param type string request.response.secure types 
	 *					('get', 'post', 'json', 'wddx', 'xml').('json', 'wddx', 'xml', 'plain', 'html').('none', 'md5', 'aes', 'aes-md5')
	 *	@param access array allowed service provider names
	 *
	**/
	public static function launch($type, $access){
		
		/**
		 *	Read request.response.secure types
		**/
		list($reqtype, $restype, $secure) = explode('.', $type);
		
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
		 *	Validate secure type
		**/
		if(!in_array($secure, array('none', 'md5', 'aes', 'aes-md5'))){
			echo 'Please check secure type. '.$secure.' not supported';
			exit;
		}
		
		/**
		 *	Save the request host address and proxy address if any
		**/
		if(isset($_SERVER['REMOTE_ADDR']))
			$memory['client'] = $_SERVER['REMOTE_ADDR'];
		if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			$memory['client'] .= " / ".$_SERVER["HTTP_X_FORWARDED_FOR"];
		
		/**
		 *	WorkflowKernel instance
		**/
		$kernel = new WorkflowKernel();
		$memory = array();
		
		/**
		 *	Read request data
		**/
		$workflow = array(
		array(
			'service' => 'sbcore.request.read.service'
		),
		array(
			'service' => 'sbcore.data.decode.service',
			'type' => $reqtype
		));
		
		$memory = $kernel->execute($workflow, $memory);
		
		if(!$memory['valid']){
			self::respond($memory, $restype);
			exit;
		}
		
		$request = $memory['result'];
		
		/**
		 *	Check for valid request
		**/
		if(!isset($request['service'])){
			echo "Please specify service to be executed with param service=root.service.operation.type";
			exit;
		}
			
		/**
		 *	Get service URI and restrict access to services
		**/
		$uri = $request['service'];
		list($root, $service, $operation, $type) = explode('.' ,$uri);
		
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
		$memory = $kernel->run(
		array(
			'service' => $uri
		), array_merge($memory, $request));
		
		if(!$memory['valid']){
			self::respond($memory, $restype);
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
		self::respond($memory, $restype, $output);
		
		return;
	}
	
	private static function respond($memory, $restype, $output = array()){
	
		/**
		 *	Prepare response
		**/
		$output = array_merge($output, array('valid', 'msg', 'status', 'details'));
		$response = array();
		foreach($output as $key){
			$response[$key] = isset($memory[$key]) ? $memory[$key] : '';
		}
		
		/**
		 *	WorkflowKernel instance
		**/
		$kernel = new WorkflowKernel();
		
		/**
		 *	Response workflow
		**/
		$workflow = array(
		array(
			'service' => 'sbcore.data.encode.service',
			'data' => $response,
			'type' => $restype
		),array(
			'service' => 'sbcore.response.write.service',
			'input' => array('data' => 'result')
		));
		
		return $kernel->execute($workflow);
	}
	
}

?>
