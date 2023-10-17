<?php

//ARQUIVO DE LOG
//include("settings/logs.php");

//CONFIGURAÇÕES DO SCRIPT
if($_SERVER["REQUEST_URI"] == '/')
{
	$pgredirect = "/home/";
}
else
{
	$pgredirect = $_SERVER["REQUEST_URI"];
}
$_SG['paginaLogin'] = '/login/redirect'.$pgredirect; //RECUPERA PAGINA ATUAL E REDIRECIONA PARA LOGIN

//INICIA A SESSAO
session_set_cookie_params(PHP_INT_MAX);
session_start();

//FUNÇÃO PARA VALIDAR O USUARIO
function validaUsuario($usuario,$senha,$hash) 
{
	global $_SG;
	
	// Usa a função addslashes para escapar as aspas
	$nusuario = addslashes($usuario);
	$nsenha = addslashes($senha);
	
	//BUSCA PELO USUARIO
	include($_ENV['DIR_APP'].'/settings/connect.php');
	
	$sql2 = "SELECT 
					uss.idUsuario,
					uss.nome, 
					te.razaosocial as empresanome, 
					te.fantasia as nomefantasia,
					uss.empresa, 
					uss.md5sessao, 
					uss.perfil,
					uss.email,
					uss.senha,
					uss.imagem
			FROM tbUsuarioEmpresa as uss 
			INNER JOIN tbEmpresa as te ON te.idEmp = uss.empresa 
			WHERE BINARY uss.email = '".$nusuario."' AND uss.status = 'A' LIMIT 1";
	$query = $mysqli->query($sql2);
	$resultado = $query->fetch_assoc();

	//FAZ A VALIDAÇÃO NOVAMENTE DE SENHA E SESSAO
	if (password_verify($nsenha, $resultado['senha']) == true && isset($_SESSION['loginUserSGI']) == false) 
	{
		//GRAVA AS VARIAVEIS DE SESSAO
		$_SESSION['idUserSGI'] = $resultado['idUsuario']; 
		$_SESSION['nomeUserSGI'] = $resultado['nome']; 
		$_SESSION['empresaUserSGI'] = $resultado['empresa'];
		$_SESSION['empresanomeUserSGI'] = $resultado['nomefantasia'];
		$_SESSION['tipoUserSGI'] = $resultado['perfil'];
		$_SESSION['loginUserSGI'] = $resultado['email']; 
		$_SESSION['hashUserSGI'] = $hash;
		$_SESSION['inicioSessaoSGI'] = date('d/m/Y - H:i');
		if($resultado['imagem'] == NULL)
		{	
			$_SESSION['userImageSGI'] = 'default-user.png';
		}
		else
		{
			$_SESSION['userImageSGI'] = $resultado['imagem'];
		}
		

		//ATUALIZA ULTIMA DATA DE LOGIN DO USUARIO
		$sql = "UPDATE tbUsuarioEmpresa SET ultLogin = '".date('Y-m-d H:i:s')."', md5sessao = '".$hash."' WHERE idUsuario = ".$_SESSION['idUserSGI'];
		$query2 = $mysqli->query($sql);
		
		//GRAVA O LOG DE ENTRADA
		//gravalog('LOG001',$resultado['usuario'],$_SESSION['empresaUserSGI'],'O USUARIO '.$resultado['nome'].' EFETUOU LOGIN - HASH DE SESSAO '.$hash,'LOGIN');
		return true;
	}
	else if(password_verify($nsenha, $resultado['senha']) == true && isset($_SESSION['loginUserSGI']) == true)
	{
		return true;
	}
	else
	{
		return false;
	}


}

//SEGURANÇA DAS PAGINAS
function protegePagina() 
{
	if (!isset($_SESSION['idUserSGI']) OR !isset($_SESSION['loginUserSGI']) OR !isset($_SESSION['empresaUserSGI']) OR !isset($_SESSION['tipoUserSGI'])) 
	{
		expulsaVisitante(); //MANDA PRA PAGINA DE LOGIN
	}
	else
	{
		//VALIDA SESSAO
		if(!validaSessao($_SESSION['hashUserSGI'],$_SESSION['idUserSGI']))
		{
			expulsaVisitante(); //MANDA PRA PAGINA DE LOGIN
		} 
	}
}

//EXPULSA USUARIO NAO LOGADO
function expulsaVisitante() 
{
	//IMPORTA VARIAVEIS
	global $_SG;

	//REMOVE VARIAVEIS DA SESSAO
	session_unset();
	
	//REDIRECIONA PARA O LOGIN
	header("Location: ".$_SG['paginaLogin']);
	exit();
}

//VALIDA ID DE SESSAO
function validaSessao($idsessao,$idUser)
{
	include($_ENV['DIR_APP'].'/settings/connect.php');
	//VERIFICA QUAL ID DE SESSAO SALVO
	$sql_sessao = "SELECT md5sessao FROM tbUsuarioEmpresa WHERE idUsuario = '$idUser' and md5sessao = '$idsessao'";
	$query_sessao = $mysqli->query($sql_sessao);
	$sessao = $query_sessao->num_rows;

	if($sessao > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>