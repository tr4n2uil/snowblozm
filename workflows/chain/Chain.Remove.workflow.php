<?php 
require_once(SBSERVICE);

/**
 *	@class ChainRemoveWorkflow
 *	@desc Removes member key from chain
 *
 *	@param keyid long int Key ID [memory]
 *	@param chainid long int Chain ID [memory]
 *	@param masterkey long int Master Key ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('keyid', 'chainid', 'masterkey', 'admin')
		);
	}

	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Chain member removed successfully';
		
		$service = array(
			'service' => 'sb.relation.delete.workflow',
			'args' => array('keyid', 'chainid', 'masterkey', 'admin'),
			'conn' => 'sbconn',
			'relation' => '`members`',
			'sqlcnd' => "where `keyid`=\${keyid} and `chainid`=(select `chainid` from `chains` where `chainid`=\${chainid} and (\${admin} or `masterkey`=\${masterkey}))",
			'errormsg' => 'Invalid Parent Chain ID / Not Permitted'
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