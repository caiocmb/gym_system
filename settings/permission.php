<?php 

function permission($module,$permission,$type) 
//(type => R-redirection | M-message only | B-true or false) (permission => CRUD)
{
	switch ($permission) {
		case 'create':
			$query = "AND criar = 'X'";
			break;		
		case 'read':
			$query = "AND visualizar = 'X'";
			break;
		case 'update':
			$query = "AND atualizar = 'X'";
			break;		
		case 'delete':
			$query = "AND excluir = 'X'";
			break;
	}
	include($_ENV['DIR_APP'].'/settings/connect.php');
	
	$sqlusr = "SELECT perfil FROM tbUsuarioEmpresa where idUsuario = '".$_SESSION['idUserSGI']."' AND perfil = 'P'";
	$resultadousr = mysqli_query($mysqli, $sqlusr);
	$totalusr = mysqli_num_rows($resultadousr);

	if($totalusr == 1) // verifica se é personalizado
	{

		$sql = "SELECT * FROM tbUsuarioPermissao where usuario = '".$_SESSION['idUserSGI']."' and modulo = '$module' ".$query;
		$resultado = mysqli_query($mysqli, $sql);
		$total = mysqli_num_rows($resultado);

		if($total == 1)
		{
			return true;
		}
		else
		{
			switch ($type) {
				case 'R':
					header('Location: /denied/');
					exit();
					break;
				case 'M':
					return "Você não possui permissão para acessar esse módulo";
					break;
				case 'B':
					return false;
					break;
			}
		}

	}	
	else //nao personalizado
	{
		$sql = "SELECT * FROM tbUsuarioPermissao where usuario = (SELECT perfil FROM tbUsuarioEmpresa where idUsuario = '".$_SESSION['idUserSGI']."') and modulo = '$module' ".$query;
		$resultado = mysqli_query($mysqli, $sql);
		$total = mysqli_num_rows($resultado);

		if($total == 1)
		{
			return true;
		}
		else
		{
			switch ($type) {
				case 'R':
					header('Location: /denied/');
					exit();
					break;
				case 'M':
					return "Você não possui permissão para acessar esse módulo";
					break;
				case 'B':
					return false;
					break;
			}
		}
	}


}

?>