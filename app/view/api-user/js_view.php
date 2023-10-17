<!-- InputMask -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/inputmask/jquery.inputmask.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/moneymask/jquery.maskMoney.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/select2/js/select2.full.min.js"></script>
<script>

$(function () {



  $("#overlayLogin").show();
  $("#salvar").prop("disabled",true);



  CarregaDados($("#cadastroForm").data("id")); 

  function CarregaDados(dataId) 
  { 
    if('<?php echo $route[2]; ?>' == 'create')
    {
        $("#usernameTitle").html('<input type="text" class="form-control" style="width: 300px;" name="userApi" id="userApi" placeholder="Username" required>');

        var table = '';
        table += "<tr>"+
                   "<td>"+
                     "<input type=\"text\" class=\"form-control\" name=\"app_insert\" id=\"app_insert\" placeholder=\"Rota da API\" required>"+
                   "</td>"+
                   "<td>"+
                   "</td>"+
                 "</tr>"; 

        $('#routeTable tbody').html(table);

        $("#overlayLogin").hide();   
        $("#salvar").prop("disabled",false);
    }
    else
    {

        $.ajax({

      
                type: 'POST',
                dataType: 'json',
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/api-user/gateway/view/'+dataId,
                async: true,
                //data: { paginacao: qtde },
                success: function(response, textStatus, jqXHR) 
                {     
                  //$("#permissionTable tr").remove();
     
                   $.each(response, function (i, element) {

                      if(typeof element.error != 'undefined')
                      { 
                        toastr.error(element.error);
                      }
                      else
                      {
                        $("#usernameTitle").text(element.username);
                        $("#token").text(element.api_key);
                        $("#app_insert").val('');

                        var table = '';
                        $.each(element.rotas, function (i, routes) {
                          
                            if(routes.rota != null)
                            {
                                if(routes.status == "A"){ $statusA = 'selected'; }else{ $statusA = ''; }
                                if(routes.status != "A"){ $statusB = 'selected'; }else{ $statusB = ''; }

                                table += "<tr>"+
                                        "<td>"+
                                          "<h5>"+routes.rota+"</h5>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <select class=\"form-control\" id=\"status["+routes.rota+"]\" name=\"status["+routes.rota+"]\" required>"+
                                        "        <option value=\" \" disabled>Selecione</option>"+
                                        "        <option value=\"A\" "+$statusA+">Ativo</option>"+
                                        "        <option value=\"I\" "+$statusB+">Inativo</option>"+
                                        "    </select>"+
                                        "</td>"+
                                      "</tr>"; 
                            }
                            else
                            {
                               table += "<tr><td colspan='3'>Não existem permissões cadastradas</td></tr>";
                            }
                              
                        });

                        table += "<tr>"+
                                        "<td>"+
                                          "<input type=\"text\" class=\"form-control\" name=\"app_insert\" id=\"app_insert\" placeholder=\"Rota da API\">"+
                                        "</td>"+
                                        "<td>"+
                                        "</td>"+
                                      "</tr>"; 

                        $('#routeTable tbody').html(table);
        
                        $("#overlayLogin").hide();   
                        $("#salvar").prop("disabled",false);
                            

                      }         
                   }); 
                  
                },
                error: function (response, textStatus, jqXHR) {
                    toastr.error(jqXHR);
                } 

            });
    }
}


    $('#cadastroForm').submit(function() {

 
            var dados = $('#cadastroForm').serialize();
            var dataId = $("#cadastroForm").data("id");

            $("#salvar").prop("disabled",true);
            $("#excluir").prop("disabled",true); 
            $("#overlayLogin").show();  
            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/api-user/gateway/update/'+dataId,                
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {      

                    if('<?php echo $route[2]; ?>' == 'create')
                    {
                        setTimeout(function() {
                          location.href='/<?php echo $_ENV['PASTA_APP_NAME']; ?>/api-user/view/'+$("#userApi").val();
                        }, 200);
                    }
                    else
                    {
                         CarregaDados($("#cadastroForm").data("id")); 
                    }

                                  
                     toastr.success(response['success']);

                     
                     $('#generate').prop('checked', false)
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