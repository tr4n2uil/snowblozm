<?php 
require_once(dirname(__FILE__).'/../../snowblozm/kernel/ServiceKernel.class.php');
require_once(dirname(__FILE__).'/Greet.class.php');

$kernel = new ServiceKernel();
$op = new Greet();
//$kernel->configure($op);
$kernel->start($op);

?>
