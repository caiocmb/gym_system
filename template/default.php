<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?php echo $_SG['nomePagina'].' - '.$_SG['titulo_site']; ?> | App</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Toastr -->
  <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
  <!-- Custom style -->
  <link rel="stylesheet" href="/dist/css/custom.css">

  <?php  if(!empty($_SG['cssPage'])){ require($_SG['cssPage']); } ?>

  <noscript>
    <meta http-equiv="refresh" content="0; url=/noscript.html">
  </noscript>




</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-<?php echo $_SG['color']; ?> navbar-<?php echo $_SG['theme']; ?>">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link pushmenu" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>  

      
    </ul>
    <a href="/" class="navbar-brand pushmenu">
        <img src="/dist/img/<?php echo $_SG['logo_empresa_light']; ?>" alt="Logo Fideliza Online" class="brand-image" >
    </a>
      



    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-<?php echo $_SG['theme']; ?>-<?php echo $_SG['color']; ?> elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link bg-<?php echo $_SG['color']; ?>">
      <img src="/dist/img/<?php echo $_SG['logo_empresa_light']; ?>" class="brand-image">
      <small class="brand-text font-weight-light"><?php echo $_SG['titulo_cabecalho']; ?></small>
    </a>

    <!-- Sidebar -->
    <div class="sidebar ">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/dist/img/<?php echo $_SESSION['userImageSGI']; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['nomeUserSGI']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">

         <?php

          function existeSubMenu($idMenu)
          {
              include($_ENV['DIR_APP'].'/settings/connect.php');

              $result_query = "SELECT * FROM tbMenu WHERE status = 'A' AND idMenu = '".$idMenu."'";
              $resultado_query = mysqli_query($mysqli, $result_query);
              $total_query = mysqli_num_rows($resultado_query);

              if($total_query > 0)
              {
                return true;
              }
              else
              {
                return false;
              }
          }

          function menuAtivo($urlMenu,$pagina)  //$route[1]
          {
              if(str_replace("/","",$urlMenu) == $pagina)
              {
                return "active";
              }
              else
              {
                return "";
              }
              
          }

          function menuAtivoPrin($menu,$pagina,$funcao)
          {
              include($_ENV['DIR_APP'].'/settings/connect.php');

              $result_query = "SELECT * FROM tbMenu WHERE status = 'A' AND idMenu = '".$menu."' AND url like ('%".$pagina."%')";
              $resultado_query = mysqli_query($mysqli, $result_query);
              $total_query = mysqli_num_rows($resultado_query);

              if($total_query > 0)
              {
                if($funcao == 'open')
                {
                    return "menu-open";
                }
                else
                {
                    return "active";
                }
                
              }
              else
              {
                return "";
              }
          }

          function menuAtivoSubmenu($menu,$pagina)
          {
              include($_ENV['DIR_APP'].'/settings/connect.php');

              $result_query = "SELECT * FROM tbMenu WHERE status = 'A' AND idMenu = '".$menu."' AND url like ('%".$pagina."%')";
              $resultado_query = mysqli_query($mysqli, $result_query);
              $total_query = mysqli_num_rows($resultado_query);

              if($total_query > 0)
              {
                
                    return "active";
                
              }
              else
              {
                return "";
              }
          }

          include($_ENV['DIR_APP'].'/settings/connect.php');

          $query_menu = "SELECT * FROM tbMenu WHERE status = 'A' AND idMenu is NULL ORDER BY posicao ASC";
          $query_menu = mysqli_query($mysqli, $query_menu);

          while($dd_menu = mysqli_fetch_assoc($query_menu))
          {
            if(permission(str_replace("/","",$dd_menu['url']),'read','B') == false and $dd_menu['permissao'] == 'S') { goto jumpA; } //PERMISSAO MENU

              if($dd_menu['idMenu'] == NULL && existeSubMenu($dd_menu['id']) == FALSE)
              {
                  echo'<li class="nav-item">
                         <a href="/'.$_ENV['PASTA_APP_NAME'].$dd_menu['url'].'" class="nav-link '.menuAtivo($dd_menu['url'],$route[1]).'">
                           <i class="nav-icon fas '.$dd_menu['icone'].'"></i>
                           <p>
                            '.$dd_menu['descricao'];
                            if($dd_menu['new'] == 'S'){ echo '<span class="right badge badge-danger">Novo</span>'; }
                       echo '
                           </p>
                         </a>
                       </li>';
              }
              else
              {
                  echo '<li class="nav-item has-treeview '.menuAtivoPrin($dd_menu['id'],$route[1],'open').'">
                          <a href="#" class="nav-link '.menuAtivoPrin($dd_menu['id'],$route[1],'menu').'">
                            <i class="nav-icon fas '.$dd_menu['icone'].'"></i>
                            <p>
                              '.$dd_menu['descricao'].'
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">';

                          $query_submenu = "SELECT * FROM tbMenu WHERE status = 'A' AND idMenu = '".$dd_menu['id']."' ORDER BY posicao ASC";
                          $query_submenu = mysqli_query($mysqli, $query_submenu);

                          while($dd_submenu = mysqli_fetch_assoc($query_submenu))
                          {
                            if(permission(str_replace("/","",$dd_submenu['url']),'read','B') == false and $dd_submenu['permissao'] == 'S') { goto jumpB; } //PERMISSAO MENU
                              if($dd_submenu['idMenu'] == $dd_menu['id'] && existeSubMenu($dd_submenu['id']) == FALSE)
                              {
                                  echo'<li class="nav-item">
                                         <a href="/'.$_ENV['PASTA_APP_NAME'].$dd_submenu['url'].'" class="nav-link '.menuAtivo($dd_submenu['url'],$route[1]).'"">
                                           <i class="nav-icon far '.$dd_submenu['icone'].'"></i>
                                           <p>
                                            '.$dd_submenu['descricao'];
                                            if($dd_submenu['new'] == 'S'){ echo '<span class="right badge badge-danger">Novo</span>'; }
                                  echo '
                                           </p>
                                         </a>
                                       </li>';
                              }
                              else
                              {
                                  echo '<li class="nav-item has-treeview ">
                                          <a href="#" class="nav-link">
                                            <i class="nav-icon far '.$dd_submenu['icone'].'"></i>
                                            <p>
                                              '.$dd_submenu['descricao'].'
                                              <i class="right fas fa-angle-left"></i>
                                            </p>
                                          </a>
                                          <ul class="nav nav-treeview">';
                                            $query_susubmenu = "SELECT * FROM tbMenu WHERE status = 'A' AND idMenu = '".$dd_submenu['id']."' ORDER BY posicao ASC";
                                            $query_susubmenu = mysqli_query($mysqli, $query_susubmenu);

                                            while($dd_susubmenu = mysqli_fetch_assoc($query_susubmenu))
                                            {
                                              if(permission(str_replace("/","",$dd_susubmenu['url']),'read','B') == false and $dd_susubmenu['permissao'] == 'S') { goto jumpC; } //PERMISSAO MENU
                                              echo'<li class="nav-item">
                                                     <a href="/'.$_ENV['PASTA_APP_NAME'].$dd_susubmenu['url'].'" class="nav-link '.menuAtivo($dd_susubmenu['url'],$route[1]).'">
                                                       <i class="nav-icon far '.$dd_susubmenu['icone'].'"></i>
                                                       <p>
                                                        '.$dd_susubmenu['descricao'];
                                                        if($dd_susubmenu['new'] == 'S'){ echo '<span class="right badge badge-danger">Novo</span>'; }
                                           echo '
                                                       </p>
                                                     </a>
                                                   </li>';
                                                   
                                                jumpC:   
                                            }
                                  echo'   </ul>
                                        </li>';
                              }

                              jumpB:
                          }  


                  echo'   </ul>
                        </li>';
              }

              jumpA:
          }  

         ?>



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $_SG['nomePagina']; ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <?php  if(!empty($_SG['contentPage'])){ require($_SG['contentPage']); } else { echo "Page Not found! Please, contact administrator"; } ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar --> 
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5><?php  if(!empty($_SG['helpTitle'])){ echo $_SG['helpTitle']; } else {  echo "Ajuda não encontrada"; } ?></h5>
      <p><?php  if(!empty($_SG['helpContent'])){ echo $_SG['helpContent']; } else {  echo "Contate o administrador do sistema."; } ?></p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <!--<div class="float-right d-none d-sm-inline">-->
      <?php echo $_SG['titulo_rodape']; ?>
    <!--</div>-->
    <!-- Default to the left -->
   <?php // Empresa: <strong> <?php echo $_SESSION['empresanomeUserSGI']; </strong> ?>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="/plugins/toastr/toastr.min.js"></script>

<?php  if(!empty($_SG['jsPage'])){ require($_SG['jsPage']); } ?>
</body>
</html>
