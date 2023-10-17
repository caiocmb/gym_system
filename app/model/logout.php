<?php 

session_destroy();
echo "<script>window.location='/".$_ENV['PASTA_APP_NAME']."';</script>"; 

?>