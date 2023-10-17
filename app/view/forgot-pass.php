<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $_SG['titulo_site']; ?> | Log in</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/toastr/toastr.min.css">
  <!-- NoJavaScript Redirect -->
  <noscript>
    <meta http-equiv="refresh" content="0; url=/noscript.html">
  </noscript>

  <link rel="shortcut icon" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/favicon.ico" type="image/x-icon"/>

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
      <a href="/" class="h4"><img src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/dist/img/<?php echo $_SG['logo_empresa_light']; ?>" style="max-height: 30px;"> </a>
    </div>
    
    <div class="card-body login-card-body">
      <div class="tab-content" id="custom-tabs-one-tabContent">

        <div class="tab-pane fade show active" id="custom-tabs-one-login" role="tabpanel" aria-labelledby="custom-tabs-one-login-tab">

          <p class="login-box-msg">Informe o código de validação</p>

          <form id="forgot-pass">
            <div class="input-group mb-3">
              <input type="hidden" name="hash1" id="hash1" value="<?php echo $route[2]; ?>">
              <input type="hidden" name="hash2" id="hash2" value="<?php echo $route[3]; ?>">
              <input type="password" id="valida" name="valida" class="form-control" placeholder="Código de Validação" required autofocus>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-key"></span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">

              </div>
              <!-- /.col -->
              <div class="col-6">
                <button type="submit" class="btn btn-secondary btn-block" id="botao">Enviar</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        
       
       </div>

      </div><!-- caio-->



    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


<!-- jQuery -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/toastr/toastr.min.js"></script>
<!-- InputMask -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/moment/moment.min.js"></script>

<script>
  $(function () {

    $("#overlayLogin").hide();

    var controle = 0;
    var controlePass = 0;


    $('#forgot-pass').submit(function() {

 
            var dados = $('#forgot-pass').serialize();

            document.getElementById('botao').disabled=true; 
            $("#overlayLogin").show();           
 
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/forgot-pass/gateway/code',
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {                     
                     toastr.success(response['success'])

                     $('#forgot-pass')[0].reset();
                     document.getElementById('botao').disabled=false;                     
                     $("#overlayLogin").hide();
                   }
                   else if(response['error'])
                   { 
                        if(controlePass < 5)
                        {
                           toastr.error(response['error'])
                           document.getElementById('botao').disabled=false;
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
                     document.getElementById('botao').disabled=true;
                   }
                      
                     
                  
                }

            });
 
            return false;
        })

  
  })


 </script>

</body>
</html>
