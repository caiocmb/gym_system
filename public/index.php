<?php

$route = explode("/",$_SERVER['REQUEST_URI']);

require(__DIR__.'/../settings/config.php');


if($route[1] == $_ENV['PASTA_APP_NAME'])
{
	$route = explode("/",str_replace("/".$_ENV['PASTA_APP_NAME'], "", $_SERVER['REQUEST_URI']));  
}

if($route[1] == NULL)
{
	$route[1] = 'home';
}


if(file_exists($_ENV['DIR_APP']."/app/controller/".$route[1].".php"))
{
	$controller = $_ENV['DIR_APP']."/app/controller/".$route[1].".php";
}
else
{
	//not found 
	include('404.php');

}

if(isset($controller))
{
	include($controller);
}


?>