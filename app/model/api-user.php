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

           
                if(isset($_POST['status']))
                {
                    foreach ($_POST['status'] as $chave => $valor)
                    {
                        $mysqli->autocommit(FALSE);
                        $mysqli -> query("UPDATE authorization SET status = '".$valor."' WHERE username = '".$route[4]."' and route_name = '".$chave."'");
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

                //$return = ["success" => 'Atualizado com Sucesso 3!']; 

                //INSERT NEW REGISTER
                if(isset($_POST['app_insert']) && !empty($_POST['app_insert']))
                {

                    $mysqli->autocommit(FALSE);
                    $mysqli -> query("INSERT INTO authorization (select '".$route[4]."','".addslashes($_POST['app_insert'])."' as routename, key_app,'A' as status from authorization where username = '".$route[4]."' group by key_app)");
                    if ($mysqli -> commit()) 
                    {
                        $return = ["success" => 'Atualizado com Sucesso 2!'];                              
                    }
                    else
                    {
                        $return = ["error" => $mysqli->error];
                        $mysqli->rollback();
                    }
                }

                //INSERT NEW REGISTER
                if(isset($_POST['userApi']) && !empty($_POST['userApi']))
                {

                    $mysqli->autocommit(FALSE);
                    $mysqli -> query("INSERT INTO authorization (username,route_name,key_app,status) VALUES ('".$_POST['userApi']."','".addslashes($_POST['app_insert'])."', '".uniqid()."','A')");
                    if ($mysqli -> commit()) 
                    {
                        $return = ["success" => 'Atualizado com Sucesso 2!'.$_POST['userApi'].'|'.$_POST['app_insert']];                              
                    }
                    else
                    {
                        $return = ["error" => $mysqli->error];
                        $mysqli->rollback();
                    }
                }

                //INSERT NEW REGISTER
                if(isset($_POST['generate']) && !empty($_POST['generate']))
                {

                    $mysqli->autocommit(FALSE);
                    $mysqli -> query("UPDATE authorization SET key_app = '".uniqid()."' WHERE username = '".$route[4]."'");
                    if ($mysqli -> commit()) 
                    {
                        $return = ["success" => 'Atualizado com Sucesso 3!'];                              
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

            $return = ['error'=>'Você não possui permissão para excluir!'];

            header('Content-type: application/json');
            echo json_encode($return);
            
            break;
        case 'view':
            include($_ENV['DIR_APP']."/settings/connect.php");
            $result_query = "SELECT * FROM authorization  WHERE username = '".$route[4]."'";
            $resultado_query = mysqli_query($mysqli, $result_query);
            $total_query = mysqli_num_rows($resultado_query);

            if($total_query == 0){

                $return[] = [ 
                    'error' => 'Registro não encontrado'
                ];
                //header('X-PHP-Response-Code: 404', true, 404);

            }else{
            
            while($dados = mysqli_fetch_assoc($resultado_query)){  

                $profile = $dados['username'];
                $keyapp = $dados['key_app'];
                $data[] = [ 
                    'rota' => $dados['route_name'],                    
                    'status' => $dados['status']
                ];
            }
                $return[] = [
                    "username" => $profile,
                    'api_key' => password_hash('gateway-'.$keyapp.'-'.$profile.'-api', PASSWORD_DEFAULT),
                    "rotas" => $data
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
            $table = 'listApiToken';
             
            // Table's primary key
            $primaryKey = 'username';
             
            // indexes
            $columns = array(
                array( 'db' => 'username', 'dt' => 0 ),
                array( 'db' => 'username',     'dt' => 1, 'formatter' => function( $d, $row ) {
            return '<a href="/'.$_ENV['PASTA_APP_NAME'].'/api-user/view/' . $d . '">Visualizar</a>';
            })  
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