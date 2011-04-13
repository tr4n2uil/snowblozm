<?php 
require_once(dirname(__FILE__).'/../../snowblozm/kernel/ServiceKernel.class.php');
require_once(dirname(__FILE__).'/../../snowblozm/loader/ComponentLoader.class.php');

$cl = new ComponentLoader();
$op = $cl->load("services.hello.greet");

$kernel = new ServiceKernel();
$kernel->start($op);

?>
