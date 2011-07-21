<?php 
require_once(SBSERVICE);

/**
 *	@class ChainCreateWorkflow
 *	@desc Creates new chain
 *
 *	@param chainname string Keychain name [memory]
 *	@param masterkey long int Key ID [memory]
 *
 *	@return return id long int Chain ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainCreateWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('key', 'email')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Chain created successfully';
		
		$service = array(
			'service' => 'sb.relation.insert.workflow',
			'args' => array('chainname', 'masterkey'),
			'conn' => 'sbconn',
			'relation' => '`chains`',
			'sqlcnd' => "(`chainname`, `masterkey`) values ('\${chainname}', \${masterkey})",
			'escparam' => array('chainname' => 'chainname')
		);
		
		return $kernel->run($service, $memory);
	}
	
	/**
	 *	@interface Service
	**/
	public function output(){
		return array('id');
	}
	
}

?>