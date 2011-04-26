<?php 
require_once('../../../init.php');
require_once(SBKERNEL);
require_once(SBCOMLOADER);

$cl = new ComponentLoader();
$op = $cl->load("hello.greet", SBROOT . 'demo/');

$kernel = new ServiceKernel();
$kernel->start($op);

?>
