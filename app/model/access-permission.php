<?php 
/* MODEL  */

/*function*/



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
              if($_SERVER['REQUEST_METHOD'] == 'POST') 
              {

                //LIMPA CAMPOS
                include($_ENV['DIR_APP']."/settings/connect.php");

                $mysqli->autocommit(FALSE);
                $mysqli -> query("UPDATE api_login_permission SET login = null, access = null, `insert` = null,`update`=null,`delete`=null WHERE id_user = '".$route[4]."' ");
                if ($mysqli -> commit()) 
                {
                    $return = ["success" => 'Atualizado com Sucesso!'];                              
                }
                else
                {
                    $return = ["error" => $mysqli->error];
                    $mysqli->rollback();
                }

                function atualizaCampos($crud,$aplicacao,$usuario)
                {
                    global $mysqli;

                    $mysqli->autocommit(FALSE);

                    if($crud == "exclude")
                    {
                        $mysqli -> query("DELETE FROM api_login_permission WHERE id_user = '".$usuario."' and application = ".$aplicacao."");
                    }
                    else
                    {
                        $mysqli -> query("UPDATE api_login_permission SET `".$crud."` = 'X' WHERE id_user = '".$usuario."' and application = ".$aplicacao."");
                    }
                    
                    if ($mysqli -> commit()) 
                    {
                        return true;              
                    }
                    else
                    {
                        $mysqli->rollback();
                        return false;
                    }
                }

                

           
                if(isset($_POST['login']))
                {
                    foreach ($_POST['login'] as $chave => $valor)
                    {
                        if($valor == 'X')
                        {
                           atualizaCampos('login',$chave,$route[4]);
                        }
                    }
                }

                if(isset($_POST['create']))
                {
                    foreach ($_POST['create'] as $chave => $valor)
                    {
                        if($valor == 'X')
                        {
                           atualizaCampos('insert',$chave,$route[4]);
                        }
                    }
                }

                if(isset($_POST['read']))
                {
                    foreach ($_POST['read'] as $chave => $valor)
                    {
                        if($valor == 'X')
                        {
                            atualizaCampos('access',$chave,$route[4]);
                        }
                    }
                }

                if(isset($_POST['update']))
                {
                    foreach ($_POST['update'] as $chave => $valor)
                    {
                        if($valor == 'X')
                        {
                            atualizaCampos('update',$chave,$route[4]);
                        }
                    }
                }

                if(isset($_POST['delete']))
                {
                    foreach ($_POST['delete'] as $chave => $valor)
                    {
                        if($valor == 'X')
                        {
                            atualizaCampos('delete',$chave,$route[4]);
                        }
                    }
                }

                if(isset($_POST['exclude']))
                {
                    foreach ($_POST['exclude'] as $chave => $valor)
                    {
                        if($valor == 'X')
                        {
                           atualizaCampos('exclude',$chave,$route[4]);
                        }
                    }
                }

                //INSERT NEW REGISTER
                if(isset($_POST['app_insert']) && !empty($_POST['app_insert']))
                {
                    if(isset($_POST['login_insert'])){ $ins_login = 'X'; }else{ $ins_login = ''; }
                    if(isset($_POST['create_insert'])){ $cre_login = 'X'; }else{ $cre_login = ''; }
                    if(isset($_POST['read_insert'])){ $red_login = 'X'; }else{ $red_login = ''; }
                    if(isset($_POST['update_insert'])){ $upd_login = 'X'; }else{ $upd_login = ''; }
                    if(isset($_POST['delete_insert'])){ $del_login = 'X'; }else{ $del_login = ''; }

                    $remove = array('{','}','[',']','+','-','?','/','\\','|','`','`','^','~',',','.',';','!','@','#','$','%','*','(',')');
                    $mysqli->autocommit(FALSE);
                    $mysqli -> query("INSERT INTO api_login_permission VALUES ('".$route[4]."','".str_replace($remove, "",strtolower(preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim(str_replace(" ", "_", strtolower(addslashes($_POST['app_insert']))))))))."','".$ins_login."','".$red_login."','".$cre_login."','".$upd_login."','".$del_login."')");
                    if ($mysqli -> commit()) 
                    {
                        $return = ["success" => 'Atualizado com Sucesso!'];                              
                    }
                    else
                    {
                        $return = ["error" => $mysqli->error];
                        $mysqli->rollback();
                    }
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
            $result_query = "SELECT lg.id,lp.application,lp.login,lp.access,lp.insert,lp.update,lp.delete,lg.nome_completo as perfil FROM api_login as lg LEFT JOIN api_login_permission lp ON lg.id = lp.id_user WHERE lg.id = '".$route[4]."'";
            $resultado_query = mysqli_query($mysqli, $result_query);
            $total_query = mysqli_num_rows($resultado_query);

            if($total_query == 0){

                $return[] = [ 
                    'error' => 'Registro não encontrado'
                ];
                //header('X-PHP-Response-Code: 404', true, 404);

            }else{
            
            while($dados = mysqli_fetch_assoc($resultado_query)){  

                $profile = $dados['perfil'];
                $data[] = [ 
                    'application' => $dados['application'],
                    'login' => $dados['login'],
                    'create' => $dados['insert'],
                    'read' => $dados['access'],
                    'update' => $dados['update'],
                    'delete' => $dados['delete']
                ];
            }
                $return[] = [
                    "profile" => $profile,
                    "permissions" => $data
                ];
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
                array( 'db' => 'status',   'dt' => 2),
                array( 'db' => 'id',     'dt' => 3, 'formatter' => function( $d, $row ) {
            return '<a href="/'.$_ENV['PASTA_APP_NAME'].'/access-permission/view/' . $d . '">Visualizar</a>';
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

            $where = "perfil = 'Personalizado'";
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