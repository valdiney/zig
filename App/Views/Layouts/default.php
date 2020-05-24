<?php 
use System\Session\Session;
use App\Models\ConfigPdv;
$configPdv = new ConfigPdv();
$configPdv = $configPdv->ConfigPdv(Session::get('idCliente'));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <base href="<?php echo BASEURL;?>">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="shortcut icon" href="public/img/favicon.png" />
  <title>
    Zig Money
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->

  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL;?>/public/assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL;?>/public/assets/css/paper-dashboard.css?v=2.0.0')}}">
 

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

  <meta name="author" content="Valdney França">
  <meta property="og:url" content="http://escoladoarduino.com.br/comedataiot/">
  <meta property="og:title" content="Comedataiot.">
  <meta property="og:site_name" content="Dendêdev">
  <meta property="og:description" content="Software para armazenagem e amostragem de dados para IoT">
  <meta property="og:image" content="http://escoladoarduino.com.br/comedataiot/public/img/visualize_graficos.jpg">
  <meta property="og:image:type" content="image/jpeg">
  <meta property="og:image:width" content="800">
  <meta property="og:image:height" content="600">
  <meta property="og:type" content="website">
  <meta name="mobile-web-app-capable" content="yes">

  <style>
  .disabled:hover {
    cursor:no-drop!important;
  }
  .perfil {
    border-radius:50%;
    width: 40px;
    height: 40px;
    object-fit: cover;
    object-position: center;
  }
  .currentRouteFromMenu {
    background:#f4f4f4;
    border-radius:10px;
    border:1px solid #dddddd;
  }
  .tabela-ajustada tr td {
    padding-top:2px!important;
    padding-bottom:2px!important;
    font-size:12px!important;
  }
  .tabela-ajustada th {
    font-size:13px!important;
  }
  </style>
</head>

<body class="">

  <div class="wrapper">

    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <div class="logo-image-small">
            
          </div>
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          <i class="fas fa-piggy-bank" style="font-size:20px;"></i> 
          <span style="color:#ff3333">Zig</span> 
          <span style="color:#33cccc">Money</span>
        </a>
      </div>

      <div class="sidebar-wrapper">
        <ul class="nav">

          <li class="">
            <a href="<?php echo BASEURL;?>/home/index"
              class="<?php currentRouteFromMenu('home/index');?>">
              <i class="fas fa-tachometer-alt" style="color:#ff3333"></i>
              <p>Inicio</p>
            </a>
          </li>

          <li class="">
            <a href="<?php echo BASEURL;?>/usuario/index"
              class="<?php currentRouteFromMenu('usuario/index');?>">
              <i class="fas fa-users" style="color:#33cccc"></i>
              <p>Usuários</p>
            </a>
          </li>
          
          <li class="">
            <?php if ($configPdv->id_tipo_pdv == 1):?>
                <a href="<?php echo BASEURL;?>/pdvPadrao/index" 
                  class="<?php currentRouteFromMenu('pdvPadrao/index');?>">
                  <i class="fas fa-coins" style="color:#00cc99"></i>
                  <p>PDV</p>
                </a>
             <?php elseif($configPdv->id_tipo_pdv == 2):?>
                <a href="<?php echo BASEURL;?>/pdvDiferencial/index" 
                  class="<?php currentRouteFromMenu('pdvDiferencial/index');?>">
                  <i class="fas fa-coins" style="color:#00cc99"></i>
                  <p>PDV</p>
                </a>
             <?php endif;?>
          </li>

           <li class="">
            <a href="<?php echo BASEURL;?>/produto/index" 
              class="<?php currentRouteFromMenu('produto/index');?>">
              <i class="fab fa-product-hunt" style="color:#99ccff"></i>
              <p>Produtos</p>
            </a>
          </li>

           <li class="">
            <a href="<?php echo BASEURL;?>/relatorio/vendasPorPeriodo" 
              class="<?php currentRouteFromMenu('relatorio/index');?> 
              <?php currentRouteFromMenu('relatorio/vendasPorPeriodo');?>">
              <i class="fas fa-file-invoice-dollar" style="color:#ffcc66"></i>
              <p>Relatórios</p>
            </a>
          </li>

          <!--<li class="active-pro">
            <a>
              <i class="fas fa-cogs" style="color:#c3c3c3"></i>
              <p><p>Configurações</p></p>
            </a>
          </li>-->

        </ul>
      </div>
    </div>

    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">

          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#" style="text-transform:lowercase!important;" 
            onclick="event.preventDefault();">
              <img class="perfil" src="<?php echo Session::get('imagem')?>">
              
              <i style="text-transform: capitalize;">
                <?php echo Session::get('nomeUsuario');?>
              </i>
            </a>
          </div>

          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
                <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <!--<a class="dropdown-item" href="#">Meus dados</a>-->
                  <a class="dropdown-item" href="<?php echo BASEURL;?>/configuracao/index">
                    <i class="fas fa-cogs"></i> Configurações
                  </a>
                  <a class="dropdown-item" href="login/logout">
                    <i class="fas fa-sign-out-alt"></i> Sair do Sistema
                  </a>

                </div>
              </li>
            </ul>
          </div>

        </div>
      </nav>
      <!-- End Navbar -->
      
      <div class="content">
        <!--Include the content into the layout-->
        <?php $this->viewRender();?>
      </div>
  </div>
      
    </div>
  </div>


  <div id="modal-validacao" class="modal fade bd-example-modal-lg" role="dialog" 
  style="background: rgba(00, 00, 00, 0.6);">
      <div class="modal-dialog" data-backdrop="static">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <!--<h4 class="modal-title"></h4>-->
              </div>
   
              <div class="modal-body">
                  <div id="modal-body-content">
                      <p id="p-modal-validation"></p>
                  </div> 
              </div>   
          </div>
      </div>
  </div>
    
  <script src="<?php echo BASEURL;?>/public/assets/js/core/jquery.min.js"></script>
  <script src="<?php echo BASEURL;?>/public/assets/js/core/popper.min.js"></script>
  <script src="<?php echo BASEURL;?>/public/assets/js/core/bootstrap.min.js"></script>
  <script src="<?php echo BASEURL;?>/public/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?php echo BASEURL;?>/public/js/helpers.js"></script>

  <script src="<?php echo BASEURL;?>/public/js/mask.js"></script>

  <script>
    $(function() {
        jQuery('.campo-moeda, .mypreco')
        .maskMoney({
          prefix:'R$ ', 
          allowNegative: true, 
          thousands:'.', decimal:',', 
          affixesStay: false
        });
    });
  </script>

</body>

</html>

<!--
  Layout
  https://demos.creative-tim.com/bs3/paper-dashboard/dashboard.html?_ga=2.109253573.1911018205.1590242535-1802779238.1590242535#
-->