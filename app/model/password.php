<?php 
/* MODEL  */



switch ($route[3]) 
    {
        
        case 'update':

                //update
              if($_SERVER['REQUEST_METHOD'] == 'POST') 
              {
                include($_ENV['DIR_APP']."/settings/connect.php");

                $sql_senha = "SELECT senha FROM tbUsuarioEmpresa WHERE idUsuario='".$_SESSION['idUserSGI']."'";
                $query_senha = $mysqli->query($sql_senha);
                $resultado = $query_senha->fetch_assoc();
                $verificaSenha = $query_senha->num_rows;
                
                if ($verificaSenha == 0)
                {  
                    $return = ["error" => 'Not found'];
                }
                else 
                { 
                      if(!password_verify($_POST['atual'], $resultado['senha']))
                      {
                          $return = ["error" => 'Senha atual não confere!']; 
                      }
                      elseif($_POST['nova'] <> $_POST['confirma'])
                      {
                          $return = ["error" => 'Nova senha não confere com a confirmação!']; 
                      }
                      else
                      {
                          $sql = "UPDATE tbUsuarioEmpresa SET senha = '".crypt($_POST['nova'])."' WHERE idUsuario = '".$_SESSION['idUserSGI']."'";
                        if ($mysqli->query($sql) === TRUE) 
                        {
                            $return = ["success" => 'Atualizado com Sucesso!'];
                        }
                      }
                    
                    

                    $mysqli->close();
                }
              }
              else
              {
                    $return = ['error'=>'Entrada incorreta!'];
              }


            header('Content-type: application/json');
            echo json_encode($return);
            
            break;

        
    }





?>