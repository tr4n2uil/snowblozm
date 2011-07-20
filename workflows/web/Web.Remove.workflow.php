<?php 
require_once(SBSERVICE);

/**
 *	@class WebRemoveWorkflow
 *	@desc Removes web member using child and parent chain IDs
 *
 *	@param child long int Chain ID [memory]
 *	@param parent long int Chain ID [memory]
 *	@param masterkey long int Master Key ID [memory]
 *	@param admin integer Is admin [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class WebRemoveWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('child', 'parent', 'masterkey', 'admin')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Web member removed successfully';
		
		$service = array(
			'service' => 'sb.relation.delete.workflow',
			'args' => array('child', 'parent', 'masterkey', 'admin'),
			'conn' => 'sbconn',
			'relation' => '`webs`',
			'sqlcnd' => "where `child`=\${child} and `parent`=(select `chainid` from `chains` where `chainid`=\${parent} and (\${admin} or `masterkey`=\${masterkey}))",
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