<?php

protegePagina();  //Acesso a pagina somente com login
//permission($route[1],'read','R'); //permissoes

if($route[2] == 'gateway')
{
	include($_ENV['DIR_APP'].'/app/model/password.php');
}
else
{
	
	switch ($route[2]) 
	{

	    default:
	    	$_SG['nomePagina'] = "Alterar Senha";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/password/view.php"; //caminho fisico do conteudo
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/password/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/password/js_view.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda Alterar Senha"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Para alterar a senha, basta inserir a sua senha atual e repetir duas vezes a nova senha."; //Conteudo da ajuda da pagina
			break;
	}

	//include default template
	include($_ENV['DIR_APP'].'/template/default.php');
}


?>