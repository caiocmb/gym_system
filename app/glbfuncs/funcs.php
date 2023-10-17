<?php

//GRAVAR E-MAIL NA TABELA DE SENDMAIL
function sendMail($processo,$email,$assunto,$mensagem) 
{

	include($_ENV['DIR_APP'].'/settings/connect.php');

	$sqlins = "INSERT INTO email (email,assunto,mensagem,auth) VALUES ('".$email."','".$assunto."','".$mensagem."','apicontrol')";
    
    if ($mysqli->query($sqlins) === TRUE) 
    {
    	return true;
    }
    else
    {
    	return false;
    }
}
/*----------------------------------------------------*/

//FUNCAO PARA CALCULAR TEMPO CORRIDO ATÉ DATA/HORARIO ATUAL
function tempoCorrido($dataAtual, $dataFuturo, $tempo)
{
 	$date_time  = new DateTime($dataAtual);

 	$diff       = $date_time->diff( new DateTime($dataFuturo));
 	 
 	if($diff->format('%y') == 0 && $diff->format('%m') == 0 && $diff->format('%d') == 0 && $diff->format('%H') == 0 && $diff->format('%i') < $tempo)
 	{
		return false;
 	}
 	else
 	{
		return true;
 	}
}
/*----------------------------------------------------*/
//SOLICITA RECUPERAÇÃO DE EMAIL
function solicitaRecuperacao($email)
{               
    include($_ENV['DIR_APP'].'/settings/connect.php');


    $hash = md5(date('YmdHis'.$email));
    $data = date('Y-m-d H:i:s');
    $codigo = rand(10000, 99999);
    $mailcrypt = md5($email);

    $sqlins = "UPDATE tbUsuarioEmpresa SET datasenha = '".$data."', md5senha = '".$hash."', codigoseg = '".$codigo."', tentaseg = '0' WHERE email = '".$email."'";
    
    if($mysqli->query($sqlins) === TRUE)
    { 
            
        $mensagem = "<h2>Olá!</h2><br/>Foi solicitado recuperação de senha para a aplicação APICONTROL<br/><a href='".$_ENV['BASE_URL']."/forgot-pass/".$hash."/".$mailcrypt."'>Clique aqui para acessar</a> <br/><br/> Ou acesse copiando e colando o link abaixo: <br/> ".$_ENV['BASE_URL']."/forgot-pass/".$hash."/".$mailcrypt." <br/> <br/> Utilize o código abaixo para validar a troca da senha: <br/> <h3>".$codigo."</h3><br/>";
        
        if(sendMail('password',$email,'Recuperar Senha',addslashes($mensagem)))
        {
            return json_encode(array("success" => 'Link para recuperação enviado no seu e-mail!'));
        }
        else
        {
            return json_encode(array("error" => 'Oops! Tivemos algum probleminha para enviar o e-mail'));;
        } 
    }
    else
    {
        return json_encode(array("error" => 'Oops! Tivemos algum probleminha'));
    }
}

/*----------------------------------------------------*/
 //INVERTER DATA
    function inverteData($data){
       if(count(explode("/",$data)) > 1)
       {
           return implode("-",array_reverse(explode("/",$data)));
       }
       elseif(count(explode("-",$data)) > 1)
       {
           return implode("/",array_reverse(explode("-",$data)));
       }
    }
/*----------------------------------------------------*/
//RETORNAR ULTIMO ID
function lastId($tabela,$empresa) 
{

    include($_ENV['DIR_APP'].'/settings/connect.php');

    $result_query = "SELECT * FROM tbSeq WHERE tabela = '$tabela' AND empresa = '$empresa' and status = 'S'";
    $resultado_query = mysqli_query($mysqli, $result_query);
    $total_query = mysqli_num_rows($resultado_query);

    if($total_query <> 0)
    {
        while($dados = mysqli_fetch_assoc($resultado_query))
        {
            return $dados['atual'];
        }
    }
    else
    {
        return 0;
    }
}
/*----------------------------------------------------*/

?>