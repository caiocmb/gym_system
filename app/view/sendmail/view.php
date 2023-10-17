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

                          <div class="col-sm-5">
                            <div class="form-group">
                              <label for="nome">E-mail</label>
                              <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" readonly>
                            </div>
                          </div>    

                          <div class="col-sm-5">
                            <div class="form-group">
                              <label for="nome">Assunto</label>
                              <input type="text" class="form-control" id="assunto" name="assunto" placeholder="Assunto" readonly>
                            </div>
                          </div>  

                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="nome">Enviado</label>
                              <input type="text" class="form-control" id="enviado" name="enviado" placeholder="Enviado" readonly>
                            </div>
                          </div>  
                                       
                          
                        </div>

                        <div class="row">
                          
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label for="nome">Mensagem</label>
                              <div class="form-control" style="min-height: 180px; background-color: #e9ecef; overflow: auto;" id="mensagem" ></div>
                            </div>
                          </div>                 
                          
                        </div>

                        <div class="row">

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="nome">Auth</label>
                              <input type="text" class="form-control" id="auth" name="auth" placeholder="Auth" readonly>
                            </div>
                          </div>    

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="nome">Data/hora</label>
                              <input type="text" class="form-control" id="datahora" name="datahora" placeholder="Data/hora" readonly>
                            </div>
                          </div>  

                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="nome">Log</label>
                              <textarea class="form-control" rows="1" name="logsm" id="logsm" placeholder="Log.." disabled></textarea>
                            </div>
                          </div>  

                          
                        </div>

                        <div class="row" id="listAtt" style="display: none;">

                          <div class="col-sm-12">
                            <div class="form-group">
                              <label for="nome">Anexos</label>
                              <div id="attch">
                              
                              </div>
                            </div>
                          </div>    

                          
                        </div>




                      </div>

                      

                  </div>
                  

                      

                        
  
                </div>
              </div>


                <div class="card-footer">
                  <div class="row">
               
                      <div class="col-sm-2" style="margin-top: 5px;">
                        <button type="button" class="btn btn-block btn-default btn-sm pull-left" value="../../sendmail/"  onclick='window.location.href=this.value'>Voltar</button>
                      </div>
                      <div class="col-sm-2 pull-right" style="margin-top: 5px;">
                        <button type="button" class="btn btn-block btn-danger btn-sm" value="Excluir" id="excluir" data-toggle="modal" data-target="#modal-danger">Excluir</button>
                      </div>
                      <div class="col-sm-2 pull-right" style="margin-top: 5px;">
                        <button type="submit" class="btn btn-block btn-primary btn-sm" value="Salvar" id="salvar">Reenviar e-mail</button>
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