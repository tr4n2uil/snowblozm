<?php 
require_once(SBSERVICE);

/**
 *	@class SecureReadWorkflow
 *	@desc Unsecures secure message to be used further
 *
 *	@param data string Data to be unsecured [memory]
 *	@param type string Decode type [memory] ('json', 'wddx', 'xml', 'plain', 'html')
 *	@param crypt string Crypt type [memory] ('none', 'rc4', 'aes', 'blowfish', 'tripledes')
 *	@param key string Key used for decryption [memory] optional default false (generated from challenge)
 *	@param keyid string Key ID returned previously [memory] optional default false
 *	@param hash string Hash type [memory] ('none', 'md5', 'sha1', 'crc32')
 *	@param email string Email if user not set [memory] optional default false
 *
 *	@return result string Unsecured message [memory]
 *	@return key long int Key used for decryption [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class SecureReadWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('data', 'type', 'crypt', 'hash'),
			'optional' => array('key' => false, 'keyid' => false, 'email' => false)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		$flag = $memory['email'] ? true : ($memory['crypt']!='none');
		
		$workflow = array(
		array(
			'service' => 'sbcore.data.decode.service',
			'output' => array('result' => 'message')
		),
		array(
			'service' => 'sbcore.data.select.service',
			'args' => array('message'),
			'opt' => true,
			'params' => array('message.message' => 'data', 'message.hash' => 'value', 'message.user' => 'user', 'message.challenge' => 'challenge')
		),
		array(
			'service' => 'sbcore.data.hash.service',
			'input' => array('type' => 'hash')
		),
		array(
			'service' => 'sbcore.data.equal.service',
			'input' => array('data' => 'result'),
			'errormsg' => 'Message integrity check failed'
		),
		array(
			'service' => 'sb.key.identify.workflow'
		),
		array(
			'service' => 'sbcore.data.decrypt.service',
			'input' => array('type' => 'crypt')
		),
		array(
			'service' => 'sbcore.data.decode.service',
			'input' => array('data' => 'result')
		));
		
		$memory = $kernel->execute($workflow, $memory);
		
		if($memory['valid']){
			$memory['result'] = array_merge($memory['result'], $memory['message']);
			if(isset($memory['result']['challenge'])) unset($memory['result']['challenge']);
			if(isset($memory['result']['message'])) unset($memory['result']['message']);
			if(isset($memory['result']['hash'])) unset($memory['result']['hash']);
			if($flag) 
				$memory['result']['keyid'] = $memory['keyid'];
		}
		
		return $memory;
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('result', 'key');
	}
	
}

?>