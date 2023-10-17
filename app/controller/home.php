<?php

protegePagina();  //Acesso a pagina somente com login
permission($route[1],'read','R');
//criar uma para as permissoes

if($route[2] == 'gateway')
{
	include($_ENV['DIR_APP'].'/app/model/login.php');
}
else
{

	switch ($route[2]) 
	{
	    case 'create':
	        //include($_ENV['DIR_APP'].'/app/view/home.php');
	        break;
	    case 'view':
	        //include($_ENV['DIR_APP'].'/app/view/home.php');
	        break;
	    default:
	    	$_SG['nomePagina'] = "Início";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/home/home.php"; //caminho fisico do conteudo
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/home/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/home/js_home.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda Dashboard"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Aqui você pode acompanhar um resumo de toda sua movimentação"; //Conteudo da ajuda da pagina
	}

	//include default template
	include($_ENV['DIR_APP'].'/template/default.php');
}


?>