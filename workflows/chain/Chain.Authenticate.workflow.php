<?php 
require_once(SBSERVICE);

/**
 *	@class ChainAuthenticateWorkflow
 *	@desc Authenticates key ID in chain and sets admin flag in memory
 *
 *	@param keyid long int Key ID [memory]
 *	@param chainid long int Chain ID [memory]
 *
 *	@return admin integer Is admin [memory]
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
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'args' => array('keyid', 'chainid'),
			'conn' => 'sbconn',
			'relation' => '`members`',
			'sqlprj' => 'count(keyid) as admin',
			'sqlcnd' => "where keyid=\${keyid} and chainid=\${chainid}",
			'errormsg' => 'Invalid Credentials'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'args' => array('result'),
			'params' => array('result.0.admin' => 'admin')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('admin');
	}
	
}

?>