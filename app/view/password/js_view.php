<!-- InputMask -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/inputmask/jquery.inputmask.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/moneymask/jquery.maskMoney.min.js"></script>
<!-- Select2 -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/select2/js/select2.full.min.js"></script>
<script>

$(function () {


  $("#overlayLogin").hide();
  
    $('#cadastroForm').submit(function() {

 
            var dados = $('#cadastroForm').serialize();

            $("#salvar").prop("disabled",true);
            $("#overlayLogin").show();  
            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/<?php echo $_ENV['PASTA_APP_NAME']; ?>/password/gateway/update/',               
                async: true,
                data: dados,
                success: function(response) {
                   
                   if(response['success'])
                   {                     
                     toastr.success(response['success']);

                     $("#salvar").prop("disabled",false);
                     $("#overlayLogin").hide();  

                   }
                   else if(response['error'])
                   {                       
                     toastr.error(response['error'])
                     $("#salvar").prop("disabled",false);
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


        
  });

</script>