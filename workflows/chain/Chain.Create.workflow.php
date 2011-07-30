<?php 
require_once(SBSERVICE);

/**
 *	@class ChainCreateWorkflow
 *	@desc Creates new chain
 *
 *	@param masterkey long int Key ID [memory]
 *	@param root string Collation root [memory] optional default '/masterkey'
 *	@param level integer Web level [memory] optional default 0
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
			'required' => array('masterkey'),
			'optional' => array('level' => 0, 'root' => false)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$memory['msg'] = 'Chain created successfully';
		$memory['root'] = $memory['root'] ? $memory['root'] : '/'.$memory['masterkey'];
		
		$service = array(
			'service' => 'sb.relation.insert.workflow',
			'args' => array('masterkey', 'level', 'root'),
			'conn' => 'sbconn',
			'relation' => '`chains`',
			'sqlcnd' => "(`masterkey`, `level`, `root`, `ctime`, `rtime`, `wtime`) values (\${masterkey}, \${level}, '\${root}', now(), now(), now())",
			'escparam' => array('root')
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