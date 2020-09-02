<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal;?>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-shopping-basket" style="color:#ff99cc"></i> Pedidos</h5>
	    </div>

		<table id="example" class="table tabela-ajustada table-striped" style="width:100%">
	        <thead>
	            <tr>
	                <th>Nº</th>
	                <th>Cliente</th>
                  <th>Total</th>
                  <th>Situação</th>
                  <th>Previsao Entrega</th>
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
            <?php foreach ($pedidos as $pedido):?>
	            <tr>
                <td><?php echo $pedido->idPedido;?></td>
                <td><?php echo $pedido->nomeCliente;?></td>
                <td>R$ <?php echo real($pedido->total);?></td>
                <td><?php echo $pedido->situacao;?></td>
                <td><?php echo date('d/m/Y', strtotime($pedido->previsaoEntrega));?></td>

                <td style="text-align:right">
                  <div class="btn-group" role="group">
                      <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cogs"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 23px, 0px); top: 0px; left: 0px; will-change: transform;">

                        <button class="dropdown-item" href="#"
                        onclick="modalFormularioPedido('<?php echo $rota;?>', <?php echo $pedido->idPedido;?>)">
                          <i class="fas fa-edit"></i> Editar
                        </button>

                        <!--<a class="dropdown-item" href="#">
                          <i class="fas fa-trash-alt" style="color:#cc6666"></i> Excluir
                        </a>-->

                      </div>
                    </div>
		              </td>
	            </tr>
            <?php endforeach;?>
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
