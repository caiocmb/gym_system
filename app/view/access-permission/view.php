<div class="content">
  <div class="container-fluid">

   <div class="row">
       <div class="col-12">
            
            <div class="card card-primary card-outline card-outline-tabs">
              <!-- overlay -->
              <div class="overlay" id="overlayLogin">
                  <i class="fas fa-2x fa-sync fa-spin"></i>
              </div>
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-dados-tab" data-toggle="pill" href="#tab-dados" role="tab" aria-controls="tab-dados" aria-selected="true">Dados</a>
                  </li>
                  
                </ul>
              </div>
              <form id="cadastroForm" method="post" data-id="<?php echo $route[3]; ?>">
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="tab-dados" role="tabpanel" aria-labelledby="custom-tabs-three-dados-tab">

                     <div class="card-body">

                        <div class="row">
                          <div class="col-sm-12">
                              <h4>Perfil: <b id="profileTitle">...</b></h4>
                          </div>
                        </div>                         

                        <div class="row">

                          <div class="col-sm-12" >
                           
                                <table class="table table-hover text-nowrap" style="margin-top:20px;" id="permissionTable"> 
                                <thead>
                                  <tr>
                                    <th>Aplicação</th>
                                    <th class="text-center">Login</th>
                                    <th class="text-center">Create</th>
                                    <th class="text-center">Read</th>                                   
                                    <th class="text-center">Update</th>
                                    <th class="text-center">Delete</th>
                                    <th class="text-center" style="border-left:2px solid #e1e1e1;border-right:2px solid #e1e1e1;">Exc Registro</th>
                                  </tr>
                                </thead>
                                <tbody>
  
                                </tbody>
                                </table>

                          </div>  

               
                          
                        </div>






                      </div>

                      

                  </div>
                  

                      

                        
  
                </div>
              </div>


                <div class="card-footer">
                  <div class="row">
               
                      <div class="col-sm-2" style="margin-top: 5px;">
                        <button type="button" class="btn btn-block btn-default btn-sm pull-left" value="../../access-permission/"  onclick='window.location.href=this.value'>Voltar</button>
                      </div>

                      <div class="col-sm-2 pull-right" style="margin-top: 5px;">
                        <button type="submit" class="btn btn-block btn-primary btn-sm" value="Salvar" id="salvar">Salvar</button>
                      </div>
                
                  </div>
                </div>


              </form>
              <!-- /.card -->
            </div>
          </div>
        




     </div>
   </div>
 </div>
</div>
<?php 
    if($_SG['action'] <> 'create')
    {
  ?>
<!-- MODAL -->

      <div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Excluir registro</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formExcluir">
            <div class="modal-body">
              <p>Para continuar a exclusão<b><span id="cancelID"></span></b>, clique em confirmar!</p>
            </div>
            <!--<input type="hidden" name="requisicaoHidden" id="requisicaoHidden">-->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Voltar</button>
              <button type="submit" id="btnUpCancel" class="btn btn-outline-light">Confirmar</button>
            </div>
           </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <?php } ?>