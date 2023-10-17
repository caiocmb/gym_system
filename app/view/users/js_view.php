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
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/users/gateway/view/'+dataId,
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
                        $("#nome").val(element.nome);
                        $("#email").val(element.email);
                        $("#status").val(element.status);
                        $("#profile").val(element.id_profile);

                      
        
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
                <?php 
                  if($_SG['action'] == 'create')
                  {
                    echo "url: '/".$_ENV['PASTA_APP_NAME']."/users/gateway/create/',";
                  }
                  else
                  {
                    echo "url: '/".$_ENV['PASTA_APP_NAME']."/users/gateway/update/'+dataId,";
                  }
                ?>                
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {                     
                     toastr.success(response['success']);

                     <?php 
                      if($_SG['action'] <> 'create')
                      {
                     ?>
                     $("#salvar").prop("disabled",false);
                     $("#excluir").prop("disabled",false); 
                     $("#overlayLogin").hide();  

                     <?php 
                      }
                      if($_SG['action'] == 'create')
                      {
                     ?>console.log(response['lastID']);
                        setTimeout(function() {
                          location.href='/users/view/'+response['lastID'];
                        }, 200);
                      <?php } ?>
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
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/users/gateway/delete/'+dataId,
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {                     
                     toastr.success(response['success']);
                     

                        setTimeout(function() {
                          location.href='/<?php echo $_ENV['PASTA_APP_NAME']; ?>/users/';
                        }, 200);
              
                     

                     
                   }
                   else if(response['error'])
                   {                       
                     toastr.error(response['error'])
                     $("#btnUpCancel").prop("disabled",false);                     
                   }
                   else
                   {
                     toastr.error('Oops! Tivemos algum probleminha, atualize a página.')
                     $("#btnUpCancel").prop("disabled",true); 
                   }
                      
                     
                  
                }

            });
 
            return false;
        })  

    
  });

</script>