<!-- InputMask -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/inputmask/jquery.inputmask.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/moneymask/jquery.maskMoney.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/select2/js/select2.full.min.js"></script>
<script>

$(function () {



  <?php 
    if($_SG['action'] <> 'create')
    {
  ?>
  $("#overlayLogin").show();
  $("#salvar").prop("disabled",true);
  <?php 
    }else
    {
      echo '$("#overlayLogin").hide();';
    } 
   ?>
  $("#excluir").prop("disabled",true);



  <?php 
    if($_SG['action'] <> 'create')
    {
  ?> 



  CarregaDados($("#cadastroForm").data("id")); 

  function CarregaDados(dataId) 
  { 
    $.ajax({

      
                type: 'POST',
                dataType: 'json',
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/sendmail/gateway/view/'+dataId,
                async: true,
                //data: { paginacao: qtde },
                success: function(response, textStatus, jqXHR) 
                {     
     
                   $.each(response, function (i, element) {

                      if(typeof element.error != 'undefined')
                      { 
                        toastr.error(element.error);
                      }
                      else
                      {
                        $("#email").val(element.email);
                        $("#assunto").val(element.assunto);
                        $("#enviado").val(element.enviado);
                        $("#mensagem").html(element.mensagem);
                        $("#auth").val(element.auth);
                        $("#datahora").val(element.datahora);
                        $("#logsm").val(element.log);

                        var anx = 1;
                        var mtn = '';
                        $.each(element.anexos, function (iat, attch) {
                            $("#listAtt").show();
                            mtn += '<a class="btn btn-app" href="/gateway/attachments/'+attch.anexo+'" target="_blank"><i class="fas fa-paperclip"></i>Anexo '+anx+'</a>';
                            anx = anx+1;
                        });
                        $("#attch").html(mtn);
        
                        $("#overlayLogin").hide();   
                        $("#salvar").prop("disabled",false);
                        $("#excluir").prop("disabled",false);

                        //$("#requisicaoHidden").val(element.id);
                        $("#cancelID").text(element.descricao);
                      }         
                   }); 
                  
                },
                error: function (response, textStatus, jqXHR) {
                    toastr.error(jqXHR);
                } 

            });
    }
<?php } ?>
    $('#cadastroForm').submit(function() {

 
            var dados = $('#cadastroForm').serialize();
            var dataId = $("#cadastroForm").data("id");

            $("#salvar").prop("disabled",true);
            $("#excluir").prop("disabled",true); 
            $("#overlayLogin").show();  
            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/sendmail/gateway/update/'+dataId,             
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {                     
                     toastr.success(response['success']);


                     $("#salvar").prop("disabled",false);
                     $("#excluir").prop("disabled",false); 
                     $("#overlayLogin").hide();  

                   }
                   else if(response['error'])
                   {                       
                     toastr.error(response['error'])
                     $("#salvar").prop("disabled",false);
                     $("#excluir").prop("disabled",false); 
                     $("#overlayLogin").hide();                   
                   }
                   else
                   {
                     toastr.error('Oops! Tivemos algum probleminha, atualize a página.')                     
                   }
                      
                     
                  
                }

            });
 
           return false;
        })


     $('#formExcluir').submit(function() {

 
            var dados = $('#formExcluir').serialize();
            var dataId = $("#cadastroForm").data("id");

            $("#btnUpCancel").prop("disabled",true);            
 
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/sendmail/gateway/delete/'+dataId,
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {                     
                     toastr.success(response['success']);
                     

                        setTimeout(function() {
                          location.href='/<?php echo $_ENV['PASTA_APP_NAME']; ?>/sendmail/';
                        }, 200);
              
                     

                     
                   }
                   else if(response['error'])
                   {                       
                     toastr.error(response['error'])
                     $("#btnUpCancel").prop("disabled",false);                     
                   }
                   else
                   {
                     toastr.error('Oops! Tivemos algum probleminha, atualize a pÃ¡gina.')
                     $("#btnUpCancel").prop("disabled",true); 
                   }
                      
                     
                  
                }

            });
 
            return false;
        })  

    
  });

</script>