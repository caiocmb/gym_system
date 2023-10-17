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

  $('#profile').select2({
      theme: 'bootstrap4',
      ajax: {
      url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-login/gateway/listaperfil/',
      data: function (params) {
        var query = {
          search: params.term,
          not_view: $("#cadastroForm").data("id"),
          page: params.page || 1
        }

        // Query parameters will be ?search=[term]&page=[page]
        return query;
      }
    }
    });

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
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-login/gateway/view/'+dataId,
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
                        $("#user").val(element.user);
                        $("#status").val(element.status);

                        //loadprofile
                        var optionprofile = new Option(element.nome_profile, element.id_profile, true, true);
                        $('#profile').append(optionprofile).trigger('change'); 
                      
        
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
                    echo "url: '/".$_ENV['PASTA_APP_NAME']."/access-login/gateway/create/',";
                  }
                  else
                  {
                    echo "url: '/".$_ENV['PASTA_APP_NAME']."/access-login/gateway/update/'+dataId,";
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
                     ?>
                        setTimeout(function() {
                          location.href='/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-login/view/'+response['lastID'];
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
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-login/gateway/delete/'+dataId,
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {                     
                     toastr.success(response['success']);
                     

                        setTimeout(function() {
                          location.href='/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-login/';
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