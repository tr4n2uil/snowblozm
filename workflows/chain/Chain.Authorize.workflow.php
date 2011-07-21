<?php 
require_once(SBSERVICE);

/**
 *	@class ChainAuthorizeWorkflow
 *	@desc Authorizes key for chain operations and sets admin flag if need be
 *
 *	@param chainid long int Chain ID [memory]
 *	@param keyid long int Key ID [memory]
 *	@param level integer Web level [memory] optional default 0
 *
 *	@return admin integer Is admin [memory]
 *
 *	@author Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/
class ChainAuthorizeWorkflow implements Service {
	
	/**
	 *	@interface Service
	**/
	public function input(){
		return array(
			'required' => array('keyid', 'chainid'),
			'optional' => array('level' => 0)
		);
	}
	
	/**
	 *	@interface Service
	**/
	public function run($memory){
		$kernel = new WorkflowKernel();
		
		$level = $memory['level'];
		
		$join1 = 'chainid=';
		$join2 = 'chainid in ';
		$master = "(select chainid from sbchains where masterkey=\${keyid})";
		$chain = "(select chainid from sbmembers where keyid=\${keyid})";
		$child = 'select child from sbwebs where parent in ';
		$query = $join1.$master.' or '.$join2.$chain;
		
		while($level--){
			$chain = '('.$child.$chain.')';
			$master = '('.$child.$master.')';
			$query = $query.' or '.$join1.$master.' or '.$join2.$chain;
		}
		
		$memory['msg'] = 'Key authorized successfully';
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'args' => array('keyid', 'chainid'),
			'conn' => 'sbconn',
			'relation' => '`chains`',
			'sqlprj' => 'count(chainid) as admin',
			'sqlcnd' => "where chainid=\${chainid} and ($query)",
			'errormsg' => 'Unable to Authorize'
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