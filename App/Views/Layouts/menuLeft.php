<?php
use System\Session\Session;
use App\Config\ConfigPerfil;
?>

<div class="sidebar-wrapper">
  <ul class="nav">

    <li class="">
      <a href="<?php echo BASEURL;?>/home"
        class="<?php currentRouteFromMenu('home', 'inicioBorder');?>">
        <i class="fas fa-tachometer-alt"></i>
        <p>Inicio</p>
      </a>
    </li>

    <!--Modulo PDV Padrão e Diferencial-->
      <li class="">
        <!--Modulo Relatórios-->
        <?php if ($configPdv->id_tipo_pdv == 1):?>
            <a href="<?php echo BASEURL;?>/pdvPadrao"
              class="<?php currentRouteFromMenu('pdvPadrao', 'pdvBorder');?>">
              <i class="fas fa-coins"></i>
              <p>PDV <small style="float:right;opacity:0.50">Padrão</small></p>
            </a>
         <?php elseif($configPdv->id_tipo_pdv == 2):?>
            <a href="<?php echo BASEURL;?>/pdvDiferencial"
              class="<?php currentRouteFromMenu('pdvDiferencial', 'pdvBorder');?>">
              <i class="fas fa-coins"></i>
              <p>PDV <small style="float:right;opacity:0.50">Diferencial</small></p>
            </a>
         <?php endif;?>
      </li>

      <?php if (Session::get('idPerfil') != ConfigPerfil::vendedor()):?>
        <li class="">
          <a href="<?php echo BASEURL;?>/produto"
            class="<?php currentRouteFromMenu('produto', 'produtoBorder');?>">
            <i class="fas fa-box-open"></i>
            <p>Produtos</p>
          </a>
        </li>
      <?php endif;?>


      <li class="">
        <a href="<?php echo BASEURL;?>/cliente"
          class="<?php currentRouteFromMenu('cliente', 'clienteBorder');?>
          <?php currentRouteFromMenu('clienteEndereco', 'clienteBorder');?>">
          <i class="fas fa-user-tie"></i>
          <p>Clientes</p>
        </a>
      </li>


      <li class="">
        <a href="<?php echo BASEURL;?>/pedido"
          class="<?php currentRouteFromMenu('pedido', 'pedidoBorder');?>">
          <i class="fas fa-shopping-basket"></i>
          <p>Pedidos</p>
        </a>
      </li>

    <?php if (Session::get('idPerfil') != ConfigPerfil::vendedor()):?>
      <li class="">
        <a href="<?php echo BASEURL;?>/relatorio/vendasPorPeriodo"
          class="<?php currentRouteFromMenu('relatorio', 'relatorioBorder');?>
          <?php currentRouteFromMenu('relatorio/vendasPorPeriodo', 'relatorioBorder');?>">
          <i class="fas fa-cart-arrow-down"></i>
          <p>Relatórios</p>
        </a>
      </li>
    <?php endif;?>


    <!--<li class="active-pro">
      <a>
        <i class="fas fa-cogs" style="color:#c3c3c3"></i>
        <p><p>Configurações</p></p>
      </a>
    </li>-->

  </ul>
</div>
<script>
  //const urlNav = `${location.origin}${location.pathname}`;
  //const elmNav = document.querySelector(`.sidebar-wrapper li a[href='${urlNav}']`);

  //console.log(urlNav, elmNav);
  if (elmNav) {
    //elmNav.parentNode.classList.add('active');
  }
</script>
