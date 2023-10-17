<?php

protegePagina();  //Acesso a pagina somente com login
permission($route[1],'read','R'); //permissoes

if($route[2] == 'gateway')
{
	include($_ENV['DIR_APP'].'/app/model/sendmail.php');
}
else
{
	
	switch ($route[2]) 
	{
	    case 'create':
	        
	        break;
	    case 'view':
	    	permission($route[1],'read','R'); //permissoes
	        $_SG['nomePagina'] = "Monitor de envio de e-mail's";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/sendmail/view.php"; //caminho fisico do conteudo
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/sendmail/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/sendmail/js_view.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda sendmail"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Login sendmail"; //Conteudo da ajuda da pagina
			break;
	    default:
	    	$_SG['nomePagina'] = "Monitor de envio de e-mail's";//titulo da pagina
			$_SG['contentPage'] = $_ENV['DIR_APP']."/app/view/sendmail/list.php"; //caminho fisico do conteudo
			$_SG['cssPage'] = $_ENV['DIR_APP']."/app/view/sendmail/css.php"; //CSSs adicionais
			$_SG['jsPage'] = $_ENV['DIR_APP']."/app/view/sendmail/js.php"; //JS adicionais
			$_SG['helpTitle'] = "Ajuda sendmail"; //Titulo da ajuda da pagina
			$_SG['helpContent'] = "Login sendmail"; //Conteudo da ajuda da pagina
			break;
	}

	//include default template
	include($_ENV['DIR_APP'].'/template/default.php');
}


?>