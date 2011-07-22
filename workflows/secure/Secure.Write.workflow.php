<?php 
require_once(SBSERVICE);

/**
 *	@class SecureWriteWorkflow
 *	@desc Builds secure message to be used further
 *
 *	@param data string Data to be secured [memory]
 *	@param type string Encode type [memory] ('json', 'wddx', 'xml', 'plain', 'html')
 *	@param crypt string Crypt type [memory] ('none', 'rc4', 'aes', 'blowfish', 'tripledes')
 *	@param key string Key used for encryption [memory] optional default false (generated from challenge)
 *	@param challenge string Challenge to be used while hashing [memory] optional default false
 *	@param keyid string Key ID returned previously [memory] optional default false
 *	@param hash string Hash type [memory] ('none', 'md5', 'sha1', 'crc32')
 *	@param email string Email if user not set [memory] optional default false
 *
 *	@return result string Secured message [memory]
 *	@return key long int Key used for encryption [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class SecureWriteWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('data', 'type', 'crypt', 'hash'),
			'optional' => array('key' => false, 'keyid' => false, 'email' => false, 'challenge' => false)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		if($memory['key'] !== false)
			$args = array('valid', 'msg', 'status', 'details', 'message', 'hash');
		else
			$args = array('user', 'challenge', 'message', 'hash');
		
		$workflow = array(
		array(
			'service' => 'sb.key.identify.workflow'
		),
		array(
			'service' => 'sbcore.data.encode.service'
		),
		array(
			'service' => 'sbcore.data.encrypt.service',
			'input' => array('data' => 'result', 'type' => 'crypt'),
			'output' => array('result' => 'message')
		),
		array(
			'service' => 'sbcore.data.hash.service',
			'input' => array('data' => 'message', 'type' => 'hash'),
			'output' => array('result' => 'hash')
		),
		array(
			'service' => 'sbcore.data.prepare.service',
			'args' => $args,
			'strict' => false,
			'valid' => $memory['valid'],
			'msg' => $memory['msg'],
			'status' => $memory['status'],
			'details' => $memory['details']
		),
		array(
			'service' => 'sbcore.data.encode.service',
			'input' => array('data' => 'result', 'type' => 'type')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('result', 'key');
	}
	
}

?>