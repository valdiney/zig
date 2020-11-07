<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal;?>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-shopping-basket" style="color:#ff99cc"></i> Pedidos</h5>
	    </div>

		  <div id="append-pedidos"></div>

    <br>

   </div>
</div>
<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>
<script src="<?php echo BASEURL;?>/public/js/helpers.js"></script>

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

tabelaDepedidosChamadosViaAjax();

function tabelaDepedidosChamadosViaAjax() {
  $('#append-pedidos').html('<br><center><h3>Carregando...</h3></center>');
  var rota = getDomain()+"/pedido/tabelaDepedidosChamadosViaAjax";

  $.post(rota, {
    '_token': '<?php echo TOKEN; ?>'

  }, function(resultado) {
    $('#append-pedidos').empty();
    $('#append-pedidos').append(resultado);
  });
}
</script>
