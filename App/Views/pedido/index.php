<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal;?>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-shopping-basket" style="color:#ff99cc"></i> Pedidos</h5>
	    </div>

		<table id="example" class="table tabela-ajustada" style="width:100%">
	        <thead>
	            <tr>
	                <th>Nº</th>
	                <th>Cliente</th>
                  <th>Vendedor</th>
                  <th>Situação</th>
                  <th style="text-align:right;padding-right:0">
                    <?php $rota = BASEURL.'/pedido/modalFormulario';?>
                    <button onclick="modalFormularioPedido('<?php echo $rota;?>', null);"
                      class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i>
                          Novo
                      </button>
                  </th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>

	            </tr>
	        <tfoot></tfoot>
	    </table>

    <br>

   </div>
</div>

<?php Modal::start([
  'id' => 'modalPedidos',
  'width' => 'modal-lg',
  'title' => 'Cadastrar Pedido'
]);?>

<div id="formulario"></div>

<?php Modal::stop();?>

<script>
function modalFormularioPedido(rota, id) {
  var url = "";

  if (id) {
      url = rota + "/" + id;
  } else {
      url = rota;
  }

  $("#formulario").html("<center><h3>Carregando...</h3></center>");
  $("#modalPedidos").modal({backdrop: 'static'});
  $("#formulario").load(url);
}
</script>
