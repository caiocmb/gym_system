<?php
$result_reporting = "select tc.razaosocial as empresa, date_format(fv.dataFecha,'%d/%m/%Y') as data, fv.idFec as id from tbsFechViag as fv 
inner join tbsClifor as tc on tc.idClifor = fv.clifor and tc.empresa = fv.empresa
where fv.idFec = '".$_GET['id']."' and fv.empresa = '".$_SESSION['empresaUserSGI']."' LIMIT 1";
$resultado_reporting = mysqli_query($mysqli, $result_reporting);
$total_reporting = mysqli_num_rows($resultado_reporting);

if ($total_reporting == 0)
{  
	  echo "Não houve informações a listar";
}
else 
{     
	while($dados = mysqli_fetch_assoc($resultado_reporting))
	{ 
	   // $nomereporting = $dados['nome'];

		echo"
			<div style=\"font-family: 'Roboto Condensed', sans-serif;\">
			<div style=\"font-size: 16px;\"><b>Cliente:</b> ".$dados['empresa']."</div>
			<div><b>Data Fechamento:</b> ".$dados['data']."</div> 
			<br/>";


			$rsviagens = "SELECT 
                                date_format(vg.dataViagem,'%d/%m/%Y') as data,
                                localFim as destino,
                                localInicio as origem,
                                valorViagem as valor,
                                valorViagem as valorSum,
                                valorPedagio,
                                valorAlimentacao,
                                valorHospedagem,
                                valorOutros,
                                mt.nome as motorista,
                                vg.idVia,
                                vg.solicitanteClifor
                            from tbsViagens as vg 
                            left join tbsMotorista as mt on mt.idMot = vg.motorista and mt.empresa = vg.empresa
                            WHERE vg.idFechamento = '".$dados['id']."' and vg.empresa = '".$_SESSION['empresaUserSGI']."' order by dataViagem ASC";
            $resul_viagens = mysqli_query($mysqli, $rsviagens);
            $total_viagens = mysqli_num_rows($resul_viagens);

            echo "<table style=\"width:100%;font-family: 'Roboto Condensed', sans-serif;font-size:13px;text-align:left;\">
					<thead>
					  <tr>
					    <th style=\"text-align:left;\">ID</th>
					    <th style=\"text-align:left;\">Data</th>
					    <th style=\"text-align:left;\">Origem</th>
					    <th style=\"text-align:left;\">Destino</th>
					    <th style=\"text-align:left;\">Valor</th>
					    <th style=\"text-align:left;\">Motorista</th>
					    <th style=\"text-align:left;\">Solicitante</th>
					  </tr>
					</thead>
					<tbody>";

                if($total_viagens == 0)
                {

                   //nao encontrado

                }
                else
                {
	                $totalgeral = 0.00;
	                $totalOutros = 0.00;

	                while($dadosviag = mysqli_fetch_assoc($resul_viagens))
	                { 
	                    $totalgeral = $totalgeral+$dadosviag['valorSum'];
	                    $totalOutros = $totalOutros + $dadosviag['valorPedagio'] + $dadosviag['valorAlimentacao'] + $dadosviag['valorHospedagem'] + $dadosviag['valorOutros'];
	                    if($dadosviag['solicitanteClifor'] == NULL or $dadosviag['solicitanteClifor'] == ''){ $solicitante = '-----'; }else{ $solicitante = $dadosviag['solicitanteClifor']; }

	                    echo "<tr>
								<td>".$dadosviag['idVia']."</td>
								<td>". $dadosviag['data']."</td>
								<td>".$dadosviag['origem']."</td>
								<td>".$dadosviag['destino']."</td>
								<td>R$ ".number_format($dadosviag['valor'],2,",","")."</td>
								<td>".$dadosviag['motorista']."</td>
								<td>".$solicitante."</td>
							  </tr>";
                	}
            	}
            	echo "</tbody>
					</table>
					<br/>
					<br/>
					<div><b>Número de viagens: </b>".$total_viagens."</div>
					<div><b>Total outros: </b>R$ ".number_format($totalOutros,2,",","")."</div>
					<div><b>Total viagens: </b>R$ ".number_format($totalgeral,2,",","")."</div>
					<div><b>Total geral: </b>R$ ".number_format(($totalgeral+$totalOutros),2,",","")."</div>
					</div>";
	}
}

?>



  


