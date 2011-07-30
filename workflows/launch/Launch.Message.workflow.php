<?php 
require_once(SBSERVICE);

/**
 *	@class LaunchMessageWorkflow
 *	@desc Launches workflows from messages
 *
 *	@param reqtype string request type [memory] ('get', 'post', 'json', 'wddx', 'xml')
 *	@param restype string response types [memory] ('json', 'wddx', 'xml', 'plain', 'html'),
 *	@param crypt string Crypt types [memory] ('none', 'rc4', 'aes', 'blowfish', 'tripledes')
 *	@param hash string Hash types [memory] ('none', 'md5', 'sha1', 'crc32')
 *	@param access array allowed service provider names [memory] optional default false
 *	@param email string Identification email to be used if not set in message [memory] optional default false
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class LaunchMessageWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('reqtype', 'restype', 'crypt' , 'hash'),
			'optional' => array('access' => array(), 'email' => false)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$workflow = array(
		array(
			'service' => 'sbcore.request.read.service'
		),
		array(
			'service' => 'sb.secure.read.workflow',
			'input' => array('type' => 'reqtype')
		),
		array(
			'service' => 'sbcore.launch.message.service',
			'input' => array('message' => 'result')
		),
		array(
			'service' => 'sb.secure.write.workflow',
			'args' => array('valid', 'msg', 'status', 'details'),
			'input' => array('data' => 'response', 'type' => 'restype'),
			'strict' => false
		),
		array(
			'service' => 'sbcore.response.write.service',
			'input' => array('data' => 'result', 'type' => 'restype')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array();
	}
	
}

?>