<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	require($_ENV['DIR_APP'].'/settings/connect.php');

	//VALIDA SE O CAMPO FOI PREENCHIDO
	$email = (addslashes(isset($_POST['email']))) ? $_POST['email'] : '';
	$senha = (addslashes(isset($_POST['senha']))) ? $_POST['senha'] : '';

	//VALIDA SE O USUÁRIO EXISTE
	$sql_base = "SELECT email FROM tbUsuarioEmpresa WHERE email='$email'";
	$query_base = $mysqli->query($sql_base);
	$verificaResult = $query_base->num_rows;	
	
	if($verificaResult !=1)
	{
		echo json_encode(array("error" => 'Usuário não encontrado'));
	}
	else
	{
		//VALIDA SE A SENHA ESTÁ CORRETA
		$sql_senha = "SELECT senha FROM tbUsuarioEmpresa WHERE email='$email'";
		$query_senha = $mysqli->query($sql_senha);
		$resultado = $query_senha->fetch_assoc();
		
		if(!password_verify($senha, $resultado['senha']))
		{			
			echo json_encode(array("error" => 'Senha incorreta'));
		}
		else
		{
			//VERIFICA SE O USUARIO NAO ESTA BLOQUEADO NO SISTEMA
			$sql_status = "SELECT status FROM tbUsuarioEmpresa WHERE email='$email' AND status = 'A'";
			$query_status = $mysqli->query($sql_status);
			$verstatus = $query_status->num_rows;
			
			if($verstatus !=1)
			{			 	
			 	echo json_encode(array("error" => 'Usuário bloqueado, contate o administrador!'));
			}
			else
			{
				$hash = md5(date('YmdHis'));
				
				if(validaUsuario($email, $senha, $hash)) 
				{
					echo json_encode(array("success" => 'Logado com sucesso, aguarde...'));
				} 
				else 
				{
					//expulsaVisitante();
					echo json_encode(array("error" => 'Faça login para continuar!'));
				}
			}	
		}
	}
}


?>