<?php 

$idRelat = $_GET['id'];
$dataatual = date('d/m/Y H:i');

header("Content-type: text/html; charset=utf-8");
echo"<title>Gerador de Relatório</title>";

$data = explode(" - ", $_GET['data']);
$datainteira = $_GET['data'];
$datainicial = $data[0];
$datafinal = $data[1];
$posicaoPG = $_GET['position'];
$formato = $_GET['format'];

if(isset($_POST['formato'])){ $formato = $_POST['formato']; } else { $formato = $_GET['format']; }

permission('rep_'.$_GET['reporting'],'read','R');

include($_ENV['DIR_APP']."/settings/connect.php");

$result_query = "SELECT * FROM tbRelatorios WHERE nomeUrl = '".$_GET['reporting']."' and status = 'A'";
$resultado_query = mysqli_query($mysqli, $result_query);
$total_query = mysqli_num_rows($resultado_query);

if ($total_query == 0)
{  
	  echo"Reporting not found...";
    exit();
}
else 
{     
	while($dados = mysqli_fetch_assoc($resultado_query))
	{ 
	    $nomereporting = $dados['nome'];
	}
}


if($posicaoPG == 'V')
{
	$posicaoFIL = 'A4';
}
else if($posicaoPG == 'H')
{
	$posicaoFIL = 'A4-L';
}

if($formato == 'pdf')
{
	require_once '/var/www/html/helpdesk/pdf2/vendor/autoload.php';

	$mpdf = new \Mpdf\Mpdf([
	    'mode' => 'utf-8',
	    'format' => $posicaoFIL,
	    'default_font_size' => 9,
	    'setAutoTopMargin' => 'stretch'
	]);

	$mpdf->SetDisplayMode('fullpage');
	$mpdf->SetTitle($nomereporting);

	$mpdf->defaultheaderfontsize = 8;     /* in pts */
	$mpdf->defaultheaderfontstyle = B;     /* blank, B, I, or BI */

	$mpdf->defaultheaderline = 1;    /* 1 to include line below header/above footer */
	$mpdf->defaultfooterfontsize = 8;     /* in pts */
	$mpdf->defaultfooterline = 1;    /* 1 to include line below header/above footer */
	$mpdf->defaultfooterfontstyle = blank;

	$mpdf->SetHTMLHeader('<table style="width: 430px; height: 55px; font-family: \'Roboto Condensed\', sans-serif;">
	<tbody>
	<tr style="height: 55.75px;">
	<td style="width: 130px; height: 55px;" rowspan="2"><img src="dist/img/'.$_SG['logo_empresa_dark'].'" style="width:120px; height: 35px;" /></td>
	<td style="width: 300px; height: 27px;"><h3>'.$nomereporting.'</h3></td>
	</tr>
	<tr style="height: 27px;">
	<td style="width: 300px; height: 27px;" style="font-size: 10px;">Emissão: '.$dataatual.'</td>
	</tr>
	</tbody>
	</table><hr/>');
	$mpdf->SetFooter($_SG['titulo_site'].' | |{PAGENO}');    /* defines footer for Odd and Even Pages - placed at Outer margin */
}

ob_start();
echo'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
include($_ENV['DIR_APP'].'/app/view/reporting/'.$_GET['reporting'].'.php');


$html = ob_get_clean();


if($formato == 'pdf')
{

$mpdf->WriteHTML($html);
$mpdf->Output();

//echo $html;
}

if($formato == 'html')


{
	echo'<table style="width: 430px; height: 55px; font-family: \'Roboto Condensed\', sans-serif;">
<tbody>
<tr style="height: 55.75px;">
<td style="width: 130px; height: 55px;" rowspan="2"><img src="/dist/img/'.$_SG['logo_empresa_dark'].'" style="width:120px; height: 35px;" /></td>
<td style="width: 300px; height: 27px;"><h3>'.$nomereporting.'</h3></td>
</tr>
<tr style="height: 27px;">
<td style="width: 300px; height: 27px;" style="font-size: 10px;">Emissão: '.$dataatual.'</td>
</tr>
</tbody>
</table><hr/>';
	echo $html;
}

if($formato == 'excel')
{

$arquivo = $nomereporting.'-'.date('d-m-Y H-i').'.xls';

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel;charset=UTF-8");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
// Envia o conteúdo do arquivo
echo "\xEF\xBB\xBF"; //UTF-8 BOM
echo"Relatório: ".$nomereporting;
echo"<br/>Emissão: ".date('d/m/Y H:i');
echo $html;
}

exit;
?>
