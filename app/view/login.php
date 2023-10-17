<?php
//include($_ENV['DIR_APP'].'/settings/config.php');
//include($_ENV['DIR_APP']."/settings/seguranca.php");

$urlRedir = implode('/', $route);
$urlRedir = '/'.$_ENV['PASTA_APP_NAME'].str_replace("/login/redirect", "", $urlRedir);

if($urlRedir == '/login/' or $urlRedir == '/login' or $urlRedir == 'login'){ $urlRedir = '/'.$_ENV['PASTA_APP_NAME'].'/home/'; }

if(isset($_SESSION['hashUserSGI']))
{
  header("Location:http://".$_SERVER[HTTP_HOST].'/'.$_ENV['PASTA_APP_NAME']);
  exit();  
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $_SG['titulo_site']; ?> | Log in</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
  <!-- Custom style -->
  <link rel="stylesheet" href="/dist/css/custom.css">
  <!-- NoJavaScript Redirect -->
  <noscript>
    <meta http-equiv="refresh" content="0; url=/noscript.html">
  </noscript>

  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

</head>
<body class="hold-transition login-page">
<div class="login-box">


  <!-- /.login-logo -->
  <div class="card card-outline card-<?php echo $_SG['color']; ?> bg-<?php echo $_SG['color']; ?>">

  	<!-- overlay -->
  	<div class="overlay" id="overlayLogin">
        <i class="fas fa-2x fa-sync fa-spin"></i>
    </div>
   

    <div class="card-header text-center">
      <a href="/" class="h4"><img src="/dist/img/<?php echo $_SG['logo_empresa_light']; ?>" style="max-height: 60px;"> </a>
    </div>
    
    <div class="card-body login-card-body">
      <div class="tab-content" id="custom-tabs-one-tabContent">

        <div class="tab-pane fade show active" id="custom-tabs-one-login" role="tabpanel" aria-labelledby="custom-tabs-one-login-tab">

          <p class="login-box-msg">Informe seus dados para prosseguir</p>

          <form id="formlogin">
            <div class="input-group mb-3">
              <input type="email" id="email" name="email" class="form-control" placeholder="E-mail" required autofocus>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">

              </div>
              <!-- /.col -->
              <div class="col-6">
                <button type="submit" class="btn btn-secondary btn-block" id="botao">Entrar</button>
              </div>
              <!-- /.col -->
            </div>
          </form>


          <p class="mb-1">
            <a href="#forgot-password" id="forgot-password" class="text-secondary">Esqueci minha senha</a>
          </p>

        
       
       </div>
       <div class="tab-pane fade" id="custom-tabs-one-forgotpassword" role="tabpanel" aria-labelledby="custom-tabs-one-forgotpassword-tab">
          
          <p class="login-box-msg">Informe seu e-mail</p>
          <form id="forgot-pass">
            <div class="input-group mb-3">
              <input type="email" id="emailPass" name="emailPass" class="form-control" placeholder="E-mail" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-5">

              </div>
              <!-- /.col -->
              <div class="col-7">
                <button type="submit" class="btn btn-secondary btn-block" id="btnRecuperar">Recuperar Senha</button>
              </div>
              <!-- /.col -->
            </div>

          </form>
          <p class="mb-1">
            <a href="#login" id="login" class="text-secondary">Voltar</a>       
          </p>
                        
       </div>
      </div><!-- caio-->

      <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist" style="display: none;">
        <a  id="custom-tabs-one-login-tab" data-toggle="pill" href="#custom-tabs-one-login" role="tab" aria-controls="custom-tabs-one-login" aria-selected="false" >Senha</a>
        <a  id="custom-tabs-one-forgotpassword-tab" data-toggle="pill" href="#custom-tabs-one-forgotpassword" role="tab" aria-controls="custom-tabs-one-forgotpassword" aria-selected="true">Voltar</a>

      </div>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="/plugins/toastr/toastr.min.js"></script>
<!-- InputMask -->
<script src="/plugins/moment/moment.min.js"></script>

<script>
  $(function () {

    $("#overlayLogin").hide();
  	
    $("#forgot-password").click(function(){
      $("#custom-tabs-one-forgotpassword-tab").click();
    });

    $("#login").click(function(){
      $("#custom-tabs-one-login-tab").click();
    });

    var controle = 0;
    var controlePass = 0;
    
    $('#formlogin').submit(function() {

 
            var dados = $('#formlogin').serialize();

            document.getElementById('botao').disabled=true;
            $("#overlayLogin").show();            
 
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/login/gateway/',
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {                     
                     toastr.success(response['success'])
                     location.href='<?php echo $urlRedir; ?>';
                   }
                   else if(response['error'])
                   { 
                        if(controle < 5)
                        {
                           toastr.error(response['error'])
                           document.getElementById('botao').disabled=false;
                           $("#overlayLogin").hide();
                           controle++;
                        }
                        else
                        {
                           toastr.error('Tentativas excedidas, atualize a página!')
                        }
                   }
                   else
                   {
                     toastr.error('Ooops! Tivemos algum probleminha, atualize a página e tente novamente.')
                     document.getElementById('botao').disabled=true;
                     $("#overlayLogin").hide();
                   }
                      
                     
                  
                }

            });
 
            return false;
        })

    $('#forgot-pass').submit(function() {

 
            var dados = $('#forgot-pass').serialize();

            document.getElementById('btnRecuperar').disabled=true; 
            $("#overlayLogin").show();           
 
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/forgot-pass/gateway/',
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {                     
                     toastr.success(response['success'])
                     $("#custom-tabs-one-login-tab").click();
                     $('#forgot-pass')[0].reset();
                     document.getElementById('btnRecuperar').disabled=false;                     
                     $("#overlayLogin").hide();
                   }
                   else if(response['error'])
                   { 
                        if(controlePass < 5)
                        {
                           toastr.error(response['error'])
                           document.getElementById('btnRecuperar').disabled=false;
                           $("#overlayLogin").hide();
                           controlePass++;
                        }
                        else
                        {
                           toastr.error('Tentativas excedidas, atualize a página!')
                        }
                   }
                   else
                   {
                     toastr.error('Ooops! Tivemos algum probleminha, atualize a página e tente novamente.')
                     document.getElementById('btnRecuperar').disabled=true;
                   }
                      
                     
                  
                }

            });
 
            return false;
        })

  
  })


 </script>

</body>
</html>
