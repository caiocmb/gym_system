<?php
if($route[2] == 'gateway')
{
	include($_ENV['DIR_APP'].'/app/model/forgot-pass.php');
}
else
{
	include($_ENV['DIR_APP'].'/app/view/forgot-pass.php');
}


?>