<?php

protegePagina();  //Acesso a pagina somente com login
permission($route[1],'read','R'); //permissoes

if($route[2] == 'gateway')
{
	//include($_ENV['DIR_APP'].'/app/model/viagens.php');
}
else
{
	
	switch ($route[2]) 
	{
	   
	    default:
	    	include($_ENV['DIR_APP'].'/app/model/reporting.php');
			break;
	}

	//include default template
	//include($_ENV['DIR_APP'].'/template/default.php');
}


?>