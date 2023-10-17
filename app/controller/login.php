<?php
if($route[2] == 'gateway')
{
	include($_ENV['DIR_APP'].'/app/model/login.php');
}
else
{
	include($_ENV['DIR_APP'].'/app/view/login.php');
}


?>