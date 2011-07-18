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
 *	@param conn array DataService instance configuration [memory] (type, user, pass, host, database)
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
	public function run($message, $memory){
		$kernel = new WorkflowKernel();
		
		$level = isset($memory['level']) ? $memory['level'] : 0;
		
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
		
		$workflow = array(
		array(
			'service' => 'sb.relation.unique.workflow',
			'input' => array('conn' => 'conn', 'keyid' => 'keyid', 'chainid' => 'chainid'),
			'output' => array('result' => 'chain'),
			'relation' => 'sbchains',
			'sqlcnd' => "where chainid=\${chainid} and ($query);",
			'sqlprj' => 'count(chainid) as admin',
			'errormsg' => 'Invalid Service Key'
		),
		array(
			'service' => 'sbcore.data.select.service',
			'input' => array('chain' => 'chain'),
			'output' => array('admin' => 'admin'),
			'params' => array('chain.admin' => 'admin')
		));
		
		return $kernel->execute($workflow, $memory);
	}
	
}

?>