<!-- DataTables  & Plugins -->
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/jszip/jszip.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {

   var table = $("#tbClifor").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,      
      "processing": true,
      "serverSide": true,
      "ajax": "/<?php echo $_ENV['PASTA_APP_NAME']; ?>/users/gateway/",
      "sDom": 'rtipl',
      "order": [[ 1, "asc" ]],
      //"sDom": '<"top"i>rt<"bottom"flp><"clear">'
      
    });

   // #myInput is a <input type="text"> element
$('#headSearch').on( 'keyup', function () {
    table.search( this.value ).draw();
} );
    
  });
</script>