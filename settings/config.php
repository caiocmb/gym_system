<?php
//CONFIGURAÇÕES GLOBAIS

$_SG['titulo_site'] = 'Gestão de Academias'; // BARRA DE TITULOS
$_SG['titulo_cabecalho'] = 'App'; //empresa
$_SG['titulo_rodape'] = '<strong>Gestão de Academias [NCBTEC]</strong> | '.date('Y'); //empresa

//$_SG['url_app'] = 'https://sgi.dev.br'; // http://url/pasta  - caminho da aplicacao

$_SG['logo_empresa_dark'] = 'logo2.png'; //APENAS O NOME DO ARQUIVO.EXTENSAO
$_SG['logo_empresa_light'] = 'logo2.png'; //APENAS O NOME DO ARQUIVO.EXTENSAO

$_SG['logo_empresa_dark_sm'] = 'logo_sm.png'; //APENAS O NOME DO ARQUIVO.EXTENSAO
$_SG['logo_empresa_light_sm'] = 'logo_sm.png'; //APENAS O NOME DO ARQUIVO.EXTENSAO

$_SG['color'] = 'bluefideliza';
$_SG['theme'] = 'dark';

/*
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);*/

require('../global.php');

include($_ENV['DIR_APP']."/settings/seguranca.php");
include($_ENV['DIR_APP']."/settings/permission.php");
include($_ENV['DIR_APP'].'/app/glbfuncs/pagginator.php');
include($_ENV['DIR_APP'].'/app/glbfuncs/funcs.php');

if(preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])){
   die('Internet explorer bloqueado. Favor utilizar Google Chrome ou Firefox!');
}

?>