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
                $result = $mysqli->query("SELECT * FROM api_login WHERE user = '".addslashes($_POST['user'])."'");
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
                
                                    $mysqli -> query("INSERT INTO api_login (nome_completo,user,password,profile,status) VALUES ('".addslashes($_POST['nome'])."','".addslashes($_POST['user'])."','".password_hash($_POST['password'], PASSWORD_DEFAULT)."','".addslashes($_POST['profile'])."','".addslashes($_POST['status'])."')");

                                    
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
                    $return = ["error" => 'Usuário já cadastrado'];
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
                            $upd_pwd = ", password = '".password_hash($_POST['password'], PASSWORD_DEFAULT)."'";
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
                    $mysqli -> query("UPDATE api_login SET nome_completo = '".addslashes($_POST['nome'])."', user = '".addslashes($_POST['user'])."' ".$upd_pwd.", status = '".addslashes($_POST['status'])."', profile = (CASE WHEN '".addslashes($_POST['profile'])."' = 0 THEN '".$route[4]."' else '".addslashes($_POST['profile'])."' end)  WHERE id = '".$route[4]."' ");
 
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
                $result = $mysqli->query("SELECT * FROM api_login WHERE profile = '".$route[4]."' AND id not in ('".$route[4]."')");
                $row_cnt = $result->num_rows;

                if($row_cnt == 0)
                {   
                    $mysqli->autocommit(FALSE);

                    $sqlins = "DELETE FROM api_login WHERE id = '".$route[4]."'";
                    $sqlins2 = "DELETE FROM api_login_permission WHERE id_user = '".$route[4]."'";

                    if ($mysqli->query($sqlins) === TRUE) 
                    {  
                        if ($mysqli->query($sqlins2) === TRUE) 
                        {  
                            $mysqli->commit();            
                            $return = ["success" => 'Excluido com Sucesso!'];            
                        }     
                        else
                        {
                            $return = ["error" => $mysqli->error];
                            $mysqli->rollback();
                        }              
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
            $result_query = "SELECT date_format(lg.last_login,'%d/%m/%Y %H:%i') as data,lg.nome_completo,lg.user,case when lg.profile=lg.id then 0 else lg.profile end as id_profile,case when lg.profile=lg.id then 'Personalizado' else pf.nome_completo end as nome_profile,lg.status,lg.id FROM api_login as lg LEFT JOIN api_login as pf on pf.id = lg.profile WHERE lg.id = '".$route[4]."'";
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
                    'nome' => $dados['nome_completo'],
                    'user' => $dados['user'],
                    'id_profile' => $dados['id_profile'],
                    'nome_profile' => $dados['nome_profile'],
                    'lastlogin' => $dados['data'],
                    'status' => $dados['status'],
                    'id' => $dados['id']
                ];
            }

            }

            header('Content-type: application/json');

            echo json_encode($return);
            break;

        case 'listaperfil':

            $pagina = $_GET['page'];
            if(!empty($_GET['not_view']))
            {
                $not_view = $_GET['not_view'];
            }
            else
            {
                $not_view = '%';
            }
            

            $page_views = 10;
            $mat = $pagina -1;
            $inicio = $mat * $page_views;

            include($_ENV['DIR_APP']."/settings/connect.php");

            $result_query = "select * from (SELECT '0' as id, 'Personalizado' as nome_completo UNION ALL SELECT id,nome_completo FROM api_login WHERE id = profile)  as tb1 WHERE (tb1.nome_completo like('%".$_GET['search']."%')) and id not in('".$not_view."') ORDER BY tb1.nome_completo ASC LIMIT ".$inicio.",".$page_views."";
            $resultado_query = mysqli_query($mysqli, $result_query);
            $total_query = mysqli_num_rows($resultado_query);
         
            if ($total_query == 0)
            {  
                $paggination = false; 
            }
            else 
            {  
                $paggination = true;
            }

            while($dados = mysqli_fetch_assoc($resultado_query))
            { 
                $keys[] = array("id"=>$dados['id'], "text"=>$dados['nome_completo']);
            }

                       
            $return = 
                [
                    'results'=> $keys,
                    'pagination'=>
                        [
                            'more'=>$paggination
                        ],
                ];

            header('Content-type: application/json');
            echo json_encode($return);
            break;

        default:
            // DB table to use
            $table = 'listApiLogin';
             
            // Table's primary key
            $primaryKey = 'id';
             
            // indexes
            $columns = array(
                array( 'db' => 'id', 'dt' => 0 ),
                array( 'db' => 'nome',  'dt' => 1 ),
                array( 'db' => 'usuario',   'dt' => 2),
                array( 'db' => 'perfil',   'dt' => 3),
                array( 'db' => 'lastlogin',   'dt' => 4),
                array( 'db' => 'status',   'dt' => 5),
                array( 'db' => 'id',     'dt' => 6, 'formatter' => function( $d, $row ) {
            return '<a href="/'.$_ENV['PASTA_APP_NAME'].'/access-login/view/' . $d . '">Visualizar</a>';
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