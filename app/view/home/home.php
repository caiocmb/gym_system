    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Acesso Rápido</h3>
              </div>
              <div class="card-body">
                <?php if(permission('access-login','read','B')){ ?>
                <a class="btn btn-app bg-success" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-login/">
                  <i class="fas fa-user"></i> Login
                </a>
                <?php } if(permission('access-permission','read','B')){ ?>
                <a class="btn btn-app bg-success" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/access-permission/">
                  <i class="fas fa-lock"></i> Perfil de Acesso
                </a>
                <?php } if(permission('api-user','read','B')){ ?>
                <a class="btn btn-app bg-success" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/api-user/">
                  <i class="fas fa-key"></i> API User/Token
                </a>
                <?php } if(permission('sendmail','read','B')){ ?>
                <a class="btn btn-app bg-warning " href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/sendmail/">
                  <i class="fas fa-envelope"></i> Sendmail Control
                </a>
                <?php } ?>
                <a class="btn btn-app bg-secondary" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/password/">
                  <i class="fas fa-key"></i> Alterar Senha
                </a>
                <?php if(permission('users','read','B')){ ?>
                <a class="btn btn-app bg-secondary" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/users/">
                  <i class="fas fa-user-plus"></i> Usuários
                </a>
                <?php } ?>
                <a class="btn btn-app bg-danger" href="/<?php echo $_ENV['PASTA_APP_NAME']; ?>/logout/">
                  <i class="fas fa-sign-out-alt"></i> Sair
                </a>
                

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>





        </div>


      </div>
    </div>