<div class="sidebar-wrapper">
  <ul class="nav">

    <li class="">
      <a href="<?php echo BASEURL;?>/home/index"
        class="<?php currentRouteFromMenu('home/index', 'inicioBorder');?>">
        <i class="fas fa-tachometer-alt"></i>
        <p>Inicio</p>
      </a>
    </li>
    
    <li class="">
      <?php if ($configPdv->id_tipo_pdv == 1):?>
          <a href="<?php echo BASEURL;?>/pdvPadrao/index" 
            class="<?php currentRouteFromMenu('pdvPadrao/index', 'pdvBorder');?>">
            <i class="fas fa-coins"></i>
            <p>PDV <small style="float:right;opacity:0.50">Padrão</small></p>
          </a>
       <?php elseif($configPdv->id_tipo_pdv == 2):?>
          <a href="<?php echo BASEURL;?>/pdvDiferencial/index" 
            class="<?php currentRouteFromMenu('pdvDiferencial/index', 'pdvBorder');?>">
            <i class="fas fa-coins"></i>
            <p>PDV <small style="float:right;opacity:0.50">Diferencial</small></p>
          </a>
       <?php endif;?>
    </li>

    <li class="">
      <a href="<?php echo BASEURL;?>/produto/index" 
        class="<?php currentRouteFromMenu('produto/index', 'produtoBorder');?>">
        <i class="fab fa-product-hunt"></i>
        <p>Produtos</p>
      </a>
    </li>

    <li class="">
      <a href="<?php echo BASEURL;?>/cliente/index" 
        class="<?php currentRouteFromMenu('cliente/index', 'clienteBorder');?>
        <?php currentRouteFromMenu('clienteEndereco/index', 'clienteBorder');?>">
        <i class="fas fa-user-tie"></i>
        <p>Clientes</p>
      </a>
    </li>

    <li class="">
      <a href="<?php echo BASEURL;?>/pedido/index" 
        class="<?php currentRouteFromMenu('pedido/index', 'pedidoBorder');?>">
        <i class="fas fa-shopping-basket"></i>
        <p>Pedidos</p>
      </a>
    </li>

    <li class="">
      <a href="<?php echo BASEURL;?>/relatorio/vendasPorPeriodo" 
        class="<?php currentRouteFromMenu('relatorio/index', 'relatorioBorder');?> 
        <?php currentRouteFromMenu('relatorio/vendasPorPeriodo', 'relatorioBorder');?>">
        <i class="fas fa-file-invoice-dollar"></i>
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
<script>
  const urlNav = `${location.origin}${location.pathname}`;
  const elmNav = document.querySelector(`.sidebar-wrapper li a[href='${urlNav}']`)
  if (elmNav) {
    elmNav.parentNode.classList.add('active');
  }
</script>