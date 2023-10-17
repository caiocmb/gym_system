<?php 
/* MODEL  */

/*function*/



/*------------------*/

switch ($route[3]) 
    {
        case 'create':
           
            
            break;

        case 'update':

            if(permission($route[1],'update','B'))//permissoes
            {
                //update
              if($_SERVER['REQUEST_METHOD'] == 'POST') 
              {
                    include($_ENV['DIR_APP']."/settings/connect.php");
                    $charsrmv = array(".",",","-","(",")"," ","/");

                    $mysqli->autocommit(FALSE);
                    
                    //TBSCLIFOR
                    $mysqli -> query("UPDATE email SET enviado = 'N' WHERE id = '".$route[4]."' ");
 
                    if ($mysqli -> commit()) 
                    {
                        $return = ["success" => 'Solicitação de reenvio realizada com Sucesso!'];                              
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
                
                $mysqli->autocommit(FALSE);
 
                $sqlins = "DELETE FROM email WHERE id = '".$route[4]."'";
 
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
                $return = ['error'=>'Você não possui permissão para excluir!'];
            } 

            header('Content-type: application/json');
            echo json_encode($return);

                      
            break;
        case 'view':
            include($_ENV['DIR_APP']."/settings/connect.php");
            
            $sql = "SELECT id,email,assunto,mensagem,case when enviado = 'S' then 'Sim' else 'Não' end as envio,logerro,auth,date_format(timestamp,'%d/%m/%Y %H:%i:%s') as data FROM `email` WHERE id = '".$route[4]."'";
            $result = $mysqli->query($sql);

            $attachment;

            if ($result->num_rows > 0) 
            {
              while($row = $result->fetch_assoc()) 
              {
                 $sql_att = "SELECT * FROM `email_attachment` WHERE id_email = '".$row['id']."' ORDER BY anexo ASC";
                 $result_att = $mysqli->query($sql_att);
             
                 
                 if ($result_att->num_rows > 0) {
                   while($row_att = $result_att->fetch_assoc()) 
                   {
                      $attachment[] = ["anexo"=>$row_att['anexo']];
                   }
                 } 

                 if(!empty($attachment))
                 {
                    $return[] = [
                        "email" => $row['email'],
                        "assunto" => $row['assunto'],
                        "mensagem" => $row['mensagem'],
                        "enviado" => $row['envio'],
                        "log" => $row['logerro'],
                        "auth" => $row['auth'],
                        "datahora" => $row['data'],
                        "id" => $row['id'],
                        "anexos" => $attachment
                        
                    ];
                 }
                 else
                 {
                    $return[] = [
                        "email" => $row['email'],
                        "assunto" => $row['assunto'],
                        "mensagem" => $row['mensagem'],
                        "enviado" => $row['envio'],
                        "log" => $row['logerro'],
                        "auth" => $row['auth'],
                        "datahora" => $row['data'],
                        "id" => $row['id']
                     ];
                 }

                 

                 unset($attachment);
              }
            }

            header('Content-type: application/json');

            echo json_encode($return);
            break;

       

        default:
            // DB table to use
            $table = 'email';
             
            // Table's primary key
            $primaryKey = 'id';
             
            // indexes
            $columns = array(
                array( 'db' => 'id', 'dt' => 0 ),
                array( 'db' => 'email',  'dt' => 1 ),
                array( 'db' => 'assunto',   'dt' => 2, 'formatter' => function( $d, $row ) { return substr(strip_tags($d), 0,30); }),
                array( 'db' => 'mensagem',   'dt' => 3, 'formatter' => function( $d, $row ) { return substr(strip_tags($d), 0,30); }),
                array( 'db' => 'enviado',   'dt' => 4, 'formatter' => function( $d, $row ) { if($d == 'S'){ return 'Sim'; } else { return 'Não'; } }),
                array( 'db' => 'timestamp',   'dt' => 5,'formatter' => function( $d, $row ) { return date( 'd/m/y H:i:s', strtotime($d)); }),
                array( 'db' => 'id',     'dt' => 6, 'formatter' => function( $d, $row ) {
            return '<a href="/'.$_ENV['PASTA_APP_NAME'].'/sendmail/view/' . $d . '">Visualizar</a>';
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