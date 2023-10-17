<?php 
/* MODEL  */

/*function*/

 function formatar_cpf_cnpj($doc) {
 
        $doc = preg_replace("/[^0-9]/", "", $doc);
        $qtd = strlen($doc);
 
        if($qtd >= 11) {
 
            if($qtd === 11 ) {
 
                $docFormatado = substr($doc, 0, 3) . '.' .
                                substr($doc, 3, 3) . '.' .
                                substr($doc, 6, 3) . '-' .
                                substr($doc, 9, 2);
            } else {
                $docFormatado = substr($doc, 0, 2) . '.' .
                                substr($doc, 2, 3) . '.' .
                                substr($doc, 5, 3) . '/' .
                                substr($doc, 8, 4) . '-' .
                                substr($doc, -2);
            }
 
            return $docFormatado;
 
        } else {
            return 'Documento invalido';
        }
    }

/*------------------*/

switch ($route[3]) 
    {
        case 'create':
            //include($_ENV['DIR_APP'].'/app/view/home.php');
            if(permission($route[1],'create','B'))//permissoes
            {
               //update
              if($_SERVER['REQUEST_METHOD'] == 'POST') 
              {
                include($_ENV['DIR_APP']."/settings/connect.php");
                $result = $mysqli->query("SELECT * FROM tbUsuarioEmpresa WHERE email = '".addslashes($_POST['user'])."'");
                $row_cnt = $result->num_rows;

                if($row_cnt == 0)
                {
                     if(isset($_POST['password']) && !empty($_POST['password']))
                     {
                         if(isset($_POST['password_confirm']) && !empty($_POST['password_confirm']))
                         {
                             if($_POST['password']==$_POST['password_confirm'])
                             {
                                if(isset($_POST['profile']) && !empty(is_numeric($_POST['profile'])))
                                {
                                    $mysqli->begin_transaction();
                
                                    $mysqli -> query("INSERT INTO tbUsuarioEmpresa (nome,email,senha,perfil,status,empresa) VALUES ('".addslashes($_POST['nome'])."','".addslashes($_POST['email'])."','".password_hash($_POST['password'], PASSWORD_DEFAULT)."','".addslashes($_POST['profile'])."','".addslashes($_POST['status'])."','1')");

                                    
                                        $ultimoID = $mysqli->insert_id;
                                
                                    if ($mysqli -> commit()) 
                                    {
                                        
                                        $return = ["success" => 'Criado com Sucesso!',"lastID" => $ultimoID];                              
                                    }
                                    else
                                    {
                                        $return = ["error" => $mysqli->error];
                                        $mysqli->rollback();
                                    }

                                    $mysqli->close();
                                }
                                else
                                {
                                    $return = ["error" => 'Informe o perfil do usuário'];
                                }
                             }
                             else
                             {
                                 $return = ["error" => 'Senha e confirmação não são iguais']; 
                             }
                         }
                         else
                         {
                             $return = ["error" => 'Preencha a confirmação de senha']; 
                         }
                     }
                     else
                     {
                         $return = ["error" => 'Informe a senha']; 
                     }
                }
                else
                {
                    $return = ["error" => 'E-mail já cadastrado'];
                }


                
              }
              else
              {
                    $return = ['error'=>'Entrada incorreta!'];
              }

            }
            else
            {
                $return = ['error'=>'Você não possui permissão para criar!'];
            } 

            header('Content-type: application/json');
            echo json_encode($return);
            
            
            break;

        case 'update':

            if(permission($route[1],'update','B'))//permissoes
            {
                //update
              if($_SERVER['REQUEST_METHOD'] == 'POST') 
              {
                $upd_pwd = '';
                if(isset($_POST['password']) && !empty($_POST['password']))
                {
                    if(isset($_POST['password_confirm']) && !empty($_POST['password_confirm']))
                    {
                        if($_POST['password']==$_POST['password_confirm'])
                        {
                            $upd_pwd = ", senha = '".password_hash($_POST['password'], PASSWORD_DEFAULT)."'";
                            $continue = 'S';
                        }
                        else
                        {
                            $return = ["error" => 'Senha e confirmação não são iguais']; 
                            $continue = 'N';
                        }
                    }
                    else
                    {
                        $return = ["error" => 'Preencha a confirmação de senha']; 
                        $continue = 'N';
                    }
                }
                else
                {
                    $continue = 'S';
                }

                //UPD
                if($continue == 'S')
                {
                    include($_ENV['DIR_APP']."/settings/connect.php");
                    $charsrmv = array(".",",","-","(",")"," ","/");

                    $mysqli->autocommit(FALSE);
                    
                    //TBSCLIFOR
                    $mysqli -> query("UPDATE tbUsuarioEmpresa SET nome = '".addslashes($_POST['nome'])."', email = '".addslashes($_POST['email'])."' ".$upd_pwd.", status = '".addslashes($_POST['status'])."', perfil = '".addslashes($_POST['profile'])."' WHERE idUsuario = '".$route[4]."' ");
 
                    if ($mysqli -> commit()) 
                    {
                        $return = ["success" => 'Atualizado com Sucesso!'];                              
                    }
                    else
                    {
                        $return = ["error" => $mysqli->error];
                        $mysqli->rollback();
                    }

                    $mysqli->close();
                }
                
              }
              else
              {
                    $return = ['error'=>'Entrada incorreta!'];
              }

            }
            else
            {
                $return = ['error'=>'Você não possui permissão para atualizar!'];
            } 

            header('Content-type: application/json');
            echo json_encode($return);
            
            break;

        case 'delete':

            if(permission($route[1],'delete','B'))//permissoes
            {
             //delete
                include($_ENV['DIR_APP']."/settings/connect.php");
                $result = $mysqli->query("SELECT * FROM tbUsuarioEmpresa WHERE perfil = '".$route[4]."'");
                $row_cnt = $result->num_rows;

                if($row_cnt == 0)
                {   
                    $mysqli->autocommit(FALSE);

                    $sqlins = "DELETE FROM tbUsuarioEmpresa WHERE idUsuario = '".$route[4]."'";


                    if ($mysqli->query($sqlins) === TRUE) 
                    {  
                        $mysqli->commit();            
                        $return = ["success" => 'Excluido com Sucesso!'];            
                    }
                    else
                    {
                        $return = ["error" => $mysqli->error];
                        $mysqli->rollback();
                    }

                    $mysqli->close();
                     
                }
                else
                {
                    $return = ["error" => "Usuário está definido como perfil para outros usuários, não sendo permitido excluir"];
                }
                
            }
            else
            {
                $return = ['error'=>'Você não possui permissão para excluir!'];
            } 

            header('Content-type: application/json');
            echo json_encode($return);
            
            break;
        case 'view':
            include($_ENV['DIR_APP']."/settings/connect.php");
            $result_query = "SELECT idUsuario as id, nome, email, case when perfil='P' then idUsuario else perfil end as usrPerfil, status FROM tbUsuarioEmpresa WHERE idUsuario = '".$route[4]."'";
            $resultado_query = mysqli_query($mysqli, $result_query);
            $total_query = mysqli_num_rows($resultado_query);

            if($total_query == 0){

                $return[] = [ 
                    'error' => 'Registro não encontrado'
                ];
                //header('X-PHP-Response-Code: 404', true, 404);

            }else{
            
            while($dados = mysqli_fetch_assoc($resultado_query)){  

                $return[] = [ 
                    'nome' => $dados['nome'],
                    'email' => $dados['email'],
                    'id_profile' => $dados['usrPerfil'],
                    'status' => $dados['status'],
                    'id' => $dados['id']
                ];
            }

            }

            header('Content-type: application/json');

            echo json_encode($return);
            break;


        default:
            // DB table to use
            $table = 'tbUsuarioEmpresa';
             
            // Table's primary key
            $primaryKey = 'idUsuario';
             
            // indexes
            $columns = array(
                array( 'db' => 'idUsuario', 'dt' => 0 ),
                array( 'db' => 'nome',  'dt' => 1 ),
                array( 'db' => 'email',   'dt' => 2),
                array( 'db' => 'ultLogin',   'dt' => 3,'formatter' => function( $d, $row ) {
                        return date( 'd/m/Y H:i', strtotime($d));
                    }),
                array( 'db' => 'status',   'dt' => 4,'formatter' => function( $d, $row ) {
                        if($d == 'A'){ return 'Ativo'; } else { return 'Inativo'; };
                    }),
                array( 'db' => 'idUsuario',     'dt' => 5, 'formatter' => function( $d, $row ) {
            return '<a href="/'.$_ENV['PASTA_APP_NAME'].'/users/view/' . $d . '">Visualizar</a>';
            } )  
                /*,
                array(
                    'db'        => 'start_date',
                    'dt'        => 4,
                    'formatter' => function( $d, $row ) {
                        return date( 'jS M y', strtotime($d));
                    }
                ),
                array(
                    'db'        => 'salary',
                    'dt'        => 5,
                    'formatter' => function( $d, $row ) {
                        return '$'.number_format($d);
                    }
                )*/
            );

            $where = "";
            //$where->where( 'empresa', 1 );
             
            // SQL server connection information
            $sql_details = array(
                'user' => $_ENV['DB_USER'],
                'pass' => $_ENV['DB_PASS'],
                'db'   => $_ENV['DB_BANCO'],
                'host' => $_ENV['DB_HOST']
            );
             
             
            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * If you just want to use the basic configuration for DataTables with PHP
             * server-side, there is no need to edit below this line.
             */
             
            //require( 'ssp.class.php' );
             
            echo json_encode(
                SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,null,$where )
            );
            break;
    }





?>