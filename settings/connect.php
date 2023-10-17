<?php
/* CRIA CONEXÃO COM O BANCO */
$mysqli = new mysqli($_ENV['DB_HOST'],$_ENV['DB_USER'],$_ENV['DB_PASS'],$_ENV['DB_BANCO']); //user,pass,db

/* VERIFICA CONEXÃO COM O BANCO */
if ($mysqli->connect_errno) {
    printf("Falha ao conectar: %s\n", $mysqli->connect_error);
    exit();
}

$mysqli->query("SET NAMES 'utf8'");
$mysqli->query('SET character_set_connection=utf8');
$mysqli->query('SET character_set_client=utf8');
$mysqli->query('SET character_set_results=utf8');
$mysqli->query('SET PERSIST information_schema_stats_expiry = 0');

//TIMEZONE
//date_default_timezone_set("America/Sao_Paulo");
date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');



?>