<?php 
require_once(SBSERVICE);

/**
 *	@class ChainAuthenticateWorkflow
 *	@desc Authenticates key ID in chain (non masterkey)
 *
 *	@param keyid long int Key ID [memory]
 *	@param chainid long int Chain ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainAuthenticateWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('keyid', 'chainid')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Key authenticated successfully';
		
		$service = array(
			'service' => 'sb.relation.unique.workflow',
			'args' => array('keyid', 'chainid'),
			'conn' => 'sbconn',
			'relation' => '`members`',
			'sqlprj' => '`chainid`',
			'sqlcnd' => "where `keyid`=\${keyid} and `chainid`=\${chainid}",
			'errormsg' => 'Invalid Credentials'
		);
		
		return $kernel->run($service, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array();
	}
	
}

?>