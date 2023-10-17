<?php

protegePagina();  //Acesso a pagina somente com login
permission($route[1],'read','R'); //permissoes

if($route[2] == 'gateway')
{
	include($_ENV['DIR_APP'].'/app/model/access-login.php');
}
else
{
	
	switch ($route[2]) 
	{
	    case 'create':
	        //include($_ENV['DIR_APP'].'/app/view/home.php');
	    	permission($route[1],'create','R'); //permissoes
	        $_SG['nomePagina'] = "Login Controle Acesso";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/access-login/view.php"; //caminho fisico do conteudo
			$_SG['action'] = 'create';
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/access-login/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/access-login/js_view.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda Login Controle Acesso"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Login Controle Acesso"; //Conteudo da ajuda da pagina
	        break;
	    case 'view':
	        //include($_ENV['DIR_APP'].'/app/view/home.php');
	    	//permission($route[1],'read','R'); //permissoes
	        $_SG['nomePagina'] = "Login Controle Acesso";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/access-login/view.php"; //caminho fisico do conteudo
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/access-login/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/access-login/js_view.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda Login Controle Acesso"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Login Controle Acesso"; //Conteudo da ajuda da pagina
			break;
	    default:
	    	$_SG['nomePagina'] = "Login Controle Acesso";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/access-login/list.php"; //caminho fisico do conteudo
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/access-login/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/access-login/js.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda Login Controle Acesso"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Login Controle Acesso"; //Conteudo da ajuda da pagina
			break;
	}

	//include default template
	include($_ENV['DIR_APP'].'/template/default.php');
}


?>