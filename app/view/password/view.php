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
                    <a class="nav-link active" id="custom-tabs-three-dados-tab" data-toggle="pill" href="#tab-dados" role="tab" aria-controls="tab-dados" aria-selected="true">Forms</a>
                  </li>
                  
                </ul>
              </div>
              <form id="cadastroForm" method="post" >
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="tab-dados" role="tabpanel" aria-labelledby="custom-tabs-three-dados-tab">

                     <div class="card-body">
                      

                     
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="origem">Senha atual</label>
                              <input type="password" class="form-control" id="atual" name="atual" placeholder="Senha atual" required autocomplete="off"> 
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="origem">Nova senha</label>
                              <input type="password" class="form-control" id="nova" name="nova" placeholder="Nova senha" required autocomplete="off"> 
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="origem">Confirmação nova senha</label>
                              <input type="password" class="form-control" id="confirma" name="confirma" placeholder="Confirmação nova senha" required autocomplete="off"> 
                            </div>
                          </div>
                        </div>

                      </div>

            
                  

                  </div>
                </div>
              </div>


                <div class="card-footer">
                  <div class="row">
               

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
