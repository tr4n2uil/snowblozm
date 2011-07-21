<?php 
require_once(SBSERVICE);

/**
 *	@class SecureWriteWorkflow
 *	@desc Builds secure message to be sent
 *
 *	@param args array Output parameters [args]
 *	@param restype string response types [memory] ('json', 'wddx', 'xml', 'plain', 'html')
 *	@param crypt string Crypt types [memory] ('none', 'rc4', 'aes', 'blowfish', 'tripledes')
 *	@param key string Key used for encryption [memory]
 *	@param hash string Hash types [memory] ('none', 'md5', 'sha1', 'crc32')
 *
 *	@return return result string Secured message [memory]
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
			'required' => array('restype', 'crypt', 'hash')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$workflow = array(
		array(
			'service' => 'sbcore.data.prepare.service',
			'args' => $memory['args'],
			'strict' => false
		),
		array(
			'service' => 'sbcore.data.encode.service',
			'input' => array('data' => 'result', 'type' => 'restype')
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
			'args' => array('valid', 'msg', 'status', 'details', 'message', 'hash'),
			'msg' => $memory['msg']
		),
		array(
			'service' => 'sbcore.data.encode.service',
			'input' => array('data' => 'result', 'type' => 'restype')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('result');
	}
	
}

?>