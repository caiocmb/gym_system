<div class="content">
  <div class="container-fluid">
   <div class="row">
       <div class="col-12">
            <div class="card">
              <div class="card-header">

                <div class="float-left btn-group">
                   <button type="button" class="btn btn-secondary" value="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-login/create/" onclick='window.location.href=this.value'>Cadastrar</button>               
                </div>
                <div class="col-5 float-right">
                  <input class="form-control " type="text" placeholder="Pesquisar" id="headSearch" autofocus>                 
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbClifor" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID.</th>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>Perfil</th>
                    <th>LastLogin</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <td colspan="7">Carregando...</td>
           
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
     </div>
   </div>
 </div>
</div>