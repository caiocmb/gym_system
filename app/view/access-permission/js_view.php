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
    $.ajax({

      
                type: 'POST',
                dataType: 'json',
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-permission/gateway/view/'+dataId,
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
                        $("#profileTitle").text(element.profile);
                        $("#app_insert").val('');

                        var table = '';
                        $.each(element.permissions, function (i, permission) {
                          
                            if(permission.application != null)
                            {
                                if(permission.login == "X"){ $login = 'checked'; }else{ $login = ''; }
                                if(permission.create == "X"){ $create = 'checked'; }else{ $create = ''; }
                                if(permission.read == "X"){ $read = 'checked'; }else{ $read = ''; }
                                if(permission.update == "X"){ $update = 'checked'; }else{ $update = ''; }
                                if(permission.delete == "X"){ $delete = 'checked'; }else{ $delete = ''; }

                                table += "<tr>"+
                                        "<td>"+
                                          "<h5>"+permission.application+"</h5>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-midnightblue'>"+
                                        "      <input type='checkbox' value='X' id=\"login['"+permission.application+"']\" name=\"login['"+permission.application+"']\" "+$login+" />"+
                                        "      <label for=\"login['"+permission.application+"']\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-midnightblue'>"+
                                        "      <input type='checkbox' value='X' id=\"create['"+permission.application+"']\" name=\"create['"+permission.application+"']\" "+$create+" />"+
                                        "      <label for=\"create['"+permission.application+"']\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-midnightblue'>"+
                                        "      <input type='checkbox' value='X' id=\"read['"+permission.application+"']\" name=\"read['"+permission.application+"']\" "+$read+" />"+
                                        "      <label for=\"read['"+permission.application+"']\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-midnightblue'>"+
                                        "      <input type='checkbox' value='X' id=\"update['"+permission.application+"']\" name=\"update['"+permission.application+"']\" "+$update+" />"+
                                        "      <label for=\"update['"+permission.application+"']\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-midnightblue'>"+
                                        "      <input type='checkbox' value='X' id=\"delete['"+permission.application+"']\" name=\"delete['"+permission.application+"']\" "+$delete+" />"+
                                        "      <label for=\"delete['"+permission.application+"']\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center' style='border-left:2px solid #e1e1e1;border-right:2px solid #e1e1e1;'>"+
                                        "  <div class='icheck-danger'>"+
                                        "      <input type='checkbox' value='X' id=\"exclude['"+permission.application+"']\" name=\"exclude['"+permission.application+"']\" />"+
                                        "      <label for=\"exclude['"+permission.application+"']\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                      "</tr>"; 
                            }
                            else
                            {
                               table += "<tr><td colspan='7'>Não existem permissões cadastradas</td></tr>";
                            }
                              
                        });

                        table += "<tr>"+
                                        "<td>"+
                                          "<input type=\"text\" style=\"text-transform:lowercase;\" class=\"form-control\" name=\"app_insert\" id=\"app_insert\" placeholder=\"Aplicação (Sem espaços, sem caracteres especiais e tudo minusculo)\">"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-info'>"+
                                        "      <input type='checkbox' id=\"login_insert\" name=\"login_insert\" />"+
                                        "      <label for=\"login_insert\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-info'>"+
                                        "      <input type='checkbox' id=\"create_insert\" name=\"create_insert\" />"+
                                        "      <label for=\"create_insert\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-info'>"+
                                        "      <input type='checkbox' id=\"read_insert\" name=\"read_insert\" />"+
                                        "      <label for=\"read_insert\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-info'>"+
                                        "      <input type='checkbox' id=\"update_insert\" name=\"update_insert\" />"+
                                        "      <label for=\"update_insert\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center'>"+
                                        "  <div class='icheck-info'>"+
                                        "      <input type='checkbox' id=\"delete_insert\" name=\"delete_insert\" />"+
                                        "      <label for=\"delete_insert\"></label>"+
                                        "  </div>"+
                                        "</td>"+
                                        "<td class='text-center' style='border-left:2px solid #e1e1e1;border-right:2px solid #e1e1e1;'>"+
                                        "</td>"+
                                      "</tr>"; 

                        $('#permissionTable tbody').html(table);
        
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


    $('#cadastroForm').submit(function() {

 
            var dados = $('#cadastroForm').serialize();
            var dataId = $("#cadastroForm").data("id");

            $("#salvar").prop("disabled",true);
            $("#excluir").prop("disabled",true); 
            $("#overlayLogin").show();  
            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-permission/gateway/update/'+dataId,                
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {      

                     CarregaDados($("#cadastroForm").data("id"));               
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