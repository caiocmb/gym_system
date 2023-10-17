<?php

	if(!empty($_POST['cliente'])){ $pescliente = "and vg.clifor in (".implode(",", $_POST['cliente']).")";} else { $pescliente = ""; }
	if(!empty($_POST['motorista'])){ $pesmot = "and vg.motorista in (".implode(",", $_POST['motorista']).")";} else { $pesmot = ""; }
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
                                vg.solicitanteClifor,
                                cf.fantasia as cliente
                            from tbsViagens as vg 
                            left join tbsMotorista as mt on mt.idMot = vg.motorista and mt.empresa = vg.empresa
                            left join tbsClifor as cf on cf.idClifor = vg.clifor and cf.empresa = vg.empresa
                            WHERE  vg.dataViagem between ('".inverteData($_POST['dataini'])."') and ('".inverteData($_POST['datafim'])."') and vg.empresa = '".$_SESSION['empresaUserSGI']."' ".$pescliente." ". $pesmot." order by vg.dataViagem ASC";
            $resul_viagens = mysqli_query($mysqli, $rsviagens);
            $total_viagens = mysqli_num_rows($resul_viagens);

            $rsdespesas = "SELECT 
                                          vg.idDes as id,
                                          date_format(vg.data,'%d/%m/%Y') as datadespesa,
                                          ti.descricao,
                                          FORMAT(COALESCE(vg.valor,0.00),2) as total,
                                          vg.idComissao as comissao,
                                          mt.nome as motorista
                                      FROM tbsDespesas as vg
                                      inner join tbsItens as ti on ti.idIte = vg.item and ti.empresa = vg.empresa
                                      inner join tbsMotorista as mt on mt.idMot = vg.motorista and mt.empresa = vg.empresa
                                      where vg.empresa = '".$_SESSION['empresaUserSGI']."' ". $pesmot." and vg.data between ('".inverteData($_POST['dataini'])."') and ('".inverteData($_POST['datafim'])."')
                                      order by vg.data ASC";
            $resul_despesas = mysqli_query($mysqli, $rsdespesas);
            $total_despesas = mysqli_num_rows($resul_despesas);
            $totalgeraldesp = 0.00;	 
	
	   // $nomereporting = $dados['nome'];
if($total_viagens == 0)
{
	echo "<h4>Não houve informações a listar</h4>";
}
else
{
		echo"
			<div style=\"font-family: 'Roboto Condensed', sans-serif;\">
			<!--<div style=\"font-size: 16px;\"><b>Motorista:</b> ".$_SESSION['nomeUserSGI']."</div>-->
			<div><b>Período solicitado:</b> ".$_POST['dataini']." à ".$_POST['datafim']."</div> 
			<br/>
			<div><b>Viagens</b></div><hr/>";




            echo "<table style=\"width:100%;font-family: 'Roboto Condensed', sans-serif;font-size:13px;text-align:left;\">
					<thead>
					  <tr>
					    <th style=\"text-align:left;\">ID</th>
					    <th style=\"text-align:left;\">Data</th>
					    <th style=\"text-align:left;\">Cliente</th>
					    <th style=\"text-align:left;\">Destino</th>
					    <th style=\"text-align:left;\">Valor</th>
					    
					    <th style=\"text-align:left;\">Motorista</th>
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
								<td>".$dadosviag['cliente']."</td>
								<td>".$dadosviag['destino']."</td>
								<td>R$ ".number_format($dadosviag['valor'],2,",","")."</td>
								
								<td>".$dadosviag['motorista']."</td>
							  </tr>";
                	}
            	}
            	echo "</tbody>
					</table>
					<br/><br/>";
					if($_POST['despesas'] == 'S') {
					echo"
					<div><b>Despesas</b></div><hr/>";

					if($total_despesas <> 0)
                {
					echo "<table style=\"width:100%;font-family: 'Roboto Condensed', sans-serif;font-size:13px;text-align:center;\">
					<thead>
					  <tr>
					    <th>ID</th>
					    <th>Data</th>
					    <th>Despesa</th>
					    <th>Valor</th>
					    <th>Motorista</th>
					  </tr>
					</thead>
					<tbody>";
}
                if($total_despesas == 0)
                {

                   echo"Não há despesas a listar";

                }
                else
                {
	                               

	                while($dadosdesp = mysqli_fetch_assoc($resul_despesas))
	                { 
	                    $totalgeraldesp = $totalgeraldesp+$dadosdesp['total'];

	                    echo "<tr>
								<td>".$dadosdesp['id']."</td>
								<td>". $dadosdesp['datadespesa']."</td>
								<td>".$dadosdesp['descricao']."</td>
								<td>R$ ".number_format($dadosdesp['total'],2,",","")."</td>
								<td>".$dadosdesp['motorista']."</td>
							  </tr>";
                	}
            	}
if($total_despesas <> 0)
                {
      echo "</tbody>
					</table>"; }
				}//fim despesas
					echo"<br/><br/>
					<hr/>
					<div><b>Número de viagens: </b>".$total_viagens."</div>
					<div><b>Total outros: </b>R$ ".number_format($totalOutros,2,",","")."</div>
					<div><b>Total viagens: </b>R$ ".number_format($totalgeral,2,",","")."</div>";
if($_POST['despesas'] == 'S') {
					echo"<div><b>Total despesas: </b>R$ ".number_format(($totalgeraldesp),2,",","")."</div>";
				}
					echo"
					<!--<div><b>Total geral: </b>R$ ".number_format(($totalgeral+$totalOutros+$totalgeraldesp),2,",","")."</div>-->
					</div>";
}

?>



  


