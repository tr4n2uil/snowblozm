<?php 
require_once(SBSERVICE);

/**
 *	@class WebAddWorkflow
 *	@desc Adds child chain to parent in the web
 *
 *	@param child long int Chain ID [memory]
 *	@param parent long int Chain ID [memory]
 *
 *	@return return id long int Web member ID [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class WebAddWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('child', 'parent')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Web member added successfully';
		
		$service = array(
			'service' => 'sb.relation.insert.workflow',
			'args' => array('child', 'parent'),
			'conn' => 'sbconn',
			'relation' => '`webs`',
			'sqlcnd' => "(`child`, `parent`) values (\${child}, \${parent})"
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