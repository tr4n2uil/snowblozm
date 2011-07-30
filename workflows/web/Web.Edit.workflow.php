<?php 
require_once(SBSERVICE);

/**
 *	@class WebEditWorkflow
 *	@desc Edits collation properties in web member
 *
 *	@param child long int Chain ID [memory]
 *	@param parent long int Chain ID [memory]
 *	@param path string Collation path [memory]
 *	@param leaf string Collation leaf [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class WebEditWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('child', 'parent', 'path', 'leaf')
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Web member collation properties edited successfully';
		
		$service = array(
			'service' => 'sb.relation.update.workflow',
			'args' => array('child', 'parent', 'path', 'leaf'),
			'conn' => 'sbconn',
			'relation' => '`webs`',
			'sqlcnd' => "set `path`='\${path}', `leaf`='\${leaf}' where `parent`=\${parent} and child=\${child}",
			'escparam' => array('path', 'leaf')
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