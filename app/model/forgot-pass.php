<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	switch ($route[3]) 
    {
        case 'code':

        	include($_ENV['DIR_APP'].'/settings/connect.php');
			//RECEBE O E-MAIL

			$sql = "SELECT * FROM tbUsuarioEmpresa WHERE md5senha = '".$_POST['hash1']."'";
			$query = $mysqli->query($sql);
			$verificaResult = $query->num_rows;
			$resultado = $query->fetch_assoc();
			
			if($verificaResult <> 0 && md5($resultado['email']) == $_POST['hash2'])
			{	
				if($_POST['valida'] == $resultado['codigoseg'])	
				{
					$codigo = rand(100000, 999999);

					$sql3 = "UPDATE tbUsuarioEmpresa SET senha = '".crypt($codigo)."', md5senha = null, datasenha = null, codigoseg = null, tentaseg = 0 WHERE idUsuario = '".$resultado['idUsuario']."'";
					$mysqli->query($sql3);

					sendMail('nothing',$resultado['email'],'Nova senha','<h2>Olá!</h2><br/>Segue a nova senha para acesso ao sistema APICONTROL<br/><b>'.$codigo.'</b>');

					echo json_encode(array("success" => 'Uma nova senha foi enviada para seu e-mail!'));
				}
				else
				{
					$sql2 = "UPDATE tbUsuarioEmpresa SET md5senha = null, datasenha = null, codigoseg = null, tentaseg = 0 WHERE idUsuario = '".$resultado['idUsuario']."'";
					$mysqli->query($sql2);

					echo json_encode(array("error" => 'Código de segurança invalido, solicite uma nova recuperação de senha.'));
				}		

			}
			else
			{
				echo json_encode(array("error" => 'E-mail não encontrado'));
			}
			
		break;

		default:
			//include($_ENV['DIR_APP'].'/app/glbfuncs/funcs.php');
			include($_ENV['DIR_APP'].'/settings/connect.php');
			//RECEBE O E-MAIL
			$email = (addslashes(isset($_POST['emailPass']))) ? $_POST['emailPass'] : '';

			$sql = "SELECT datasenha,md5senha,email,empresa FROM tbUsuarioEmpresa WHERE email = '".$email."'";
			$query = $mysqli->query($sql);
			$verificaResult = $query->num_rows;
			$resultado = $query->fetch_assoc();
			
			if($verificaResult <> 0)
			{
				if(($resultado['datasenha'] || $resultado['md5senha']) == NULL)
				{ 
					//CHAMA FUNCAO PARA SOLICITAR
					echo solicitaRecuperacao($email);
				}
				else
				{
					//VERIFICA SE O USUARIO SOLICITOU RECUPERAÇÃO EM MENOS DE 5 MIN
					if(tempoCorrido(date('Y-m-d H:i:s'), $resultado['datasenha'], '5'))
					{
						//CHAMA FUNCAO PARA SOLICITAR
						echo solicitaRecuperacao($email);
					}
					else
					{
						//RETORNO AO USUARIO PARA AGUARDAR
						echo json_encode(array("error" => 'Aguarde alguns minutos para nova solicitação'));
					}
				}
			}
			else
			{
				echo json_encode(array("error" => 'E-mail não encontrado'));
			}
		break;
	}

}
else
{
	echo json_encode(array("error" => 'Erro interno, tente novamente!'));
}
?>