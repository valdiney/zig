<?php

use System\Session\Session; ?>

<style type="text/css">
  .imagem-perfil {
    width: 30px;
    height: 30px;
    object-fit: cover;
    object-position: center;
    border-radius: 50%;
  }

  .cool-btn {
    background: #1da1f2;
    color: white !important;
  }
</style>

<div class="row">

  <div class="card col-lg-12 content-div">
    <div class="card-body">
      <h5 class="card-title"><i class="fas fa-cart-arrow-down"></i>
        Filtros
      </h5>
    </div>

    <form method="POST" action="<?php echo BASEURL; ?>/relatorio/vendasChamadaAjax" id="form">

      <!-- token de segurança -->
      <input type="hidden" name="_token" value="<?php echo TOKEN; ?>" />

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="periodo_de">Período de</label>
            <input type="date" class="form-control" name="de" id="periodo_de" value="<?php echo date('Y') . '-' . date('m') . '-' . '01' ?>">
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label for="periodo_ate">Período até</label>
            <input type="date" class="form-control" name="ate" id="periodo_ate" value="<?php echo date('Y-m-d') ?>">
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label for="id_usuario">Vendedor *</label>
            <select class="form-control" name="id_usuario" id="id_usuario">
              <option value="todos">Todos</option>
              <?php foreach ($usuarios as $usuario) : ?>
                <option value="<?php echo $usuario->id; ?>">
                  <?php echo $usuario->nome; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <button type="submit" class="btn btn-sm btn-success text-right pull-right" id="buscar-vendas" style="margin-left:10px">
            <i class="fas fa-search"></i> Buscar
          </button>

          <a onclick="baixarEmFormatoXls()" class="cool-btn btn btn-sm btn-defoult text-right pull-right" id="baixar-xls" title="Baixar em formato XLS!">
            <i class="fas fa-cloud-download-alt"></i> Xls
          </a>

          <a onclick="baixarEmFormatoPDF()" class="cool-btn btn btn-sm btn-defoult text-right pull-right" id="baixar-pdf" title="Baixar em formato PDF!">
            <i class="fas fa-cloud-download-alt"></i> PDF
          </a>

        </div>

      </div>
      <!--end row-->
    </form>

    <br>

  </div>
</div>

<div class="row">
  <div class="card col-lg-12 content-div">
    <!--Renderiza a tabela de vendas-->
    <div id="div-tabela-vendas"></div>
    <br>
  </div>
</div>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>

<script type="text/javascript">
  $("#buscar-vendas").click(function() {
    vendas();
    return false;
  });

  vendas();

  function vendas() {
    $('#div-tabela-vendas').html('<br><center><h3>Carregando...</h3></center>');
    var rota = $('#form').attr('action');
    $.post(rota, $('#form').serialize(), function(resultado) {
      $('#div-tabela-vendas').empty();
      $('#div-tabela-vendas').append(resultado);
    });
  }

  function baixarEmFormatoXls() {
    var rota = "<?php echo BASEURL; ?>/relatorio/gerarXls";
    rota += "/" + $("#periodo_de").val();
    rota += "/" + $("#periodo_ate").val();
    rota += "/" + $("#id_usuario").val();

    window.location.href = rota;
  }

  function baixarEmFormatoPDF() {
    var rota = "<?php echo BASEURL; ?>/relatorio/gerarPDF";
    rota += "/" + $("#periodo_de").val();
    rota += "/" + $("#periodo_ate").val();
    rota += "/" + $("#id_usuario").val();

    window.location.href = rota;
  }
</script>
