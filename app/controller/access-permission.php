<?php

protegePagina();  //Acesso a pagina somente com login
permission($route[1],'read','R'); //permissoes

if($route[2] == 'gateway')
{
	include($_ENV['DIR_APP'].'/app/model/access-permission.php');
}
else
{
	
	switch ($route[2]) 
	{
	    case 'create':
	        //include($_ENV['DIR_APP'].'/app/view/home.php');
	    	permission($route[1],'create','R'); //permissoes
	        $_SG['nomePagina'] = "Perfil de Acesso";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/access-permission/view.php"; //caminho fisico do conteudo
			$_SG['action'] = 'create';
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/access-permission/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/access-permission/js_view.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda Permissões de Acesso"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Permissões de Acesso"; //Conteudo da ajuda da pagina
	        break;
	    case 'view':
	        //include($_ENV['DIR_APP'].'/app/view/home.php');
	    	//permission($route[1],'read','R'); //permissoes
	        $_SG['nomePagina'] = "Perfil de Acesso";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/access-permission/view.php"; //caminho fisico do conteudo
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/access-permission/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/access-permission/js_view.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda Permissões de Acesso"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Permissões de Acesso"; //Conteudo da ajuda da pagina
			break;
	    default:
	    	$_SG['nomePagina'] = "Perfil de Acesso";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/access-permission/list.php"; //caminho fisico do conteudo
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/access-permission/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/access-permission/js.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda Permissões de Acesso"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Permissões de Acesso"; //Conteudo da ajuda da pagina
			break;
	}

	//include default template
	include($_ENV['DIR_APP'].'/template/default.php');
}


?>