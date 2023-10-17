<?php
$result_reporting = "select tc.nome as motorista, date_format(fv.dataFecha,'%d/%m/%Y') as data, fv.idFec as id 
from tbsComissao as fv 
inner join tbsMotorista as tc on tc.idMot = fv.motorista and tc.empresa = fv.empresa
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
			<div style=\"font-size: 16px;\"><b>Motorista:</b> ".$dados['motorista']."</div>
			<div><b>Data Fechamento:</b> ".$dados['data']."</div> 
			<br/>
			<div><b>Viagens</b></div><hr/>";


			$rsviagens = "SELECT 
                                date_format(vg.dataViagem,'%d/%m/%Y') as data,
                                vg.localFim as destino,
                                vg.valorViagem as valor,
                                vg.valorViagem as valorSum,
                                vg.valorPedagio,
                                vg.valorAlimentacao,
                                vg.valorHospedagem,
                                vg.valorOutros,
                                mt.nome as motorista,
                                vg.idVia,
                                tc.razaosocial as clifor,
                                tc.idClifor as idcliente,
                                (FORMAT(COALESCE(sum(case
                                  when (vg.statusComissao <> 'F' or vg.statusComissao is null) then
                                    case 
                                        when (tr.pedagio = 'S') then (vg.valorViagem*(mt.comissaopedagio/100)) 
                                        else (vg.valorViagem*(mt.comissaonormal/100)) 
                                    end
                                  else
                                    (vg.valorComissao)
                                end    
                                ),0.00),2)) as Comissao
                            from tbsViagens as vg 
                            left join tbsClifor tc on tc.idClifor = vg.clifor and tc.empresa = vg.empresa
                            left join tbsMotorista as mt on mt.idMot = vg.motorista and mt.empresa = vg.empresa
                            left join tbsRota as tr on tr.idRota = vg.rota and tr.empresa = vg.empresa
                            WHERE vg.idComissao = '".$dados['id']."' and vg.empresa = '".$_SESSION['empresaUserSGI']."' 
                            group BY    
                                vg.dataViagem,
                                vg.localFim,
                                vg.valorViagem,
                                vg.valorViagem,
                                vg.valorPedagio,
                                vg.valorAlimentacao,
                                vg.valorHospedagem,
                                vg.valorOutros,
                                mt.nome,
                                vg.idVia,
                                tc.razaosocial,
                                tc.idClifor
                            order by vg.dataViagem ASC";
            $resul_viagens = mysqli_query($mysqli, $rsviagens);
            $total_viagens = mysqli_num_rows($resul_viagens);

            $rsdespesas = "SELECT 
                                          dp.idDes as id,
                                          date_format(dp.data,'%d/%m/%Y') as datadespesa,
                                          ti.descricao,
                                          FORMAT(COALESCE(dp.valor,0.00),2) as total,
                                          idComissao as comissao
                                      FROM tbsDespesas as dp
                                      inner join tbsItens as ti on ti.idIte = dp.item and ti.empresa = dp.empresa
                                      where dp.empresa = '".$_SESSION['empresaUserSGI']."' and dp.idComissao = '".$dados['id']."' 
                                      order by dp.data ASC";
            $resul_despesas = mysqli_query($mysqli, $rsdespesas);
            $total_despesas = mysqli_num_rows($resul_despesas);
            $totalgeraldesp = 0.00;	 

            echo "<table style=\"width:100%;font-family: 'Roboto Condensed', sans-serif;font-size:13px;text-align:center;\">
					<thead>
					  <tr>
					    <th>ID</th>
					    <th>Data</th>
					    <th>Clifor</th>
					    <th>Destino</th>
					    <th>Valor</th>
					    <th>Comissão</th>
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
	                $totalAvista = 0.00;	

	                while($dadosviag = mysqli_fetch_assoc($resul_viagens))
	                { 
	                    $totalgeral = $totalgeral+$dadosviag['valorSum'];
	                    $totalComissao = $totalComissao + $dadosviag['Comissao'];

	                    if($dadosviag['idcliente'] == 14){ $totalAvista = $totalAvista + $dadosviag['valorSum']; }

	                    echo "<tr>
								<td>".$dadosviag['idVia']."</td>
								<td>". $dadosviag['data']."</td>
								<td>".$dadosviag['clifor']."</td>
								<td>".$dadosviag['destino']."</td>
								<td>R$ ".number_format($dadosviag['valor'],2,",","")."</td>
								<td>R$ ".number_format($dadosviag['Comissao'],2,",","")."</td>
							  </tr>";
                	}
            	}

      echo "</tbody>
					</table>
					<br/><br/>
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

							  </tr>";
                	}
            	}
if($total_despesas <> 0)
                {
      echo "</tbody>
					</table>"; }


					echo"<br/><br/>
					<hr/>
					<div><b>Número de viagens: </b>".$total_viagens."</div>
					<div><b>Total viagens: </b>R$ ".number_format($totalgeral,2,",","")."</div>
					<div><b>Total comissão: </b>R$ ".number_format(($totalComissao),2,",","")."</div>
					<div><b>Total despesas: </b>R$ ".number_format(($totalgeraldesp),2,",","")."</div> 
					<div><b>Total a vista (Cliente Avulso): </b>R$ ".number_format(($totalAvista),2,",","")."</div>
					<div><b>Valor a receber: </b>R$ ".number_format(((($totalComissao+$totalgeraldesp)-$totalAvista)),2,",","")."</div>
					</div>";
	}
}

?>



  


