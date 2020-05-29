<!--Usando o Html Components-->
<?php use App\Views\Layouts\HtmlComponents\Modal;?>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-user-tie" style="color:#ad54da"></i> Clientes</h5>
	    </div>

		<table id="example" class="table tabela-ajustada table-striped" style="width:100%">
	        <thead>
	            <tr>
	                <th>Nome / Rasão Social</th>
	                <th>Email</th>
	                <th>Designação</th>
	                <th>Segmento</th>
	                <th style="text-align:right;padding-right:0">
	                	<?php $rota = BASEURL.'/cliente/modalFormulario';?>
	                	<button onclick="modalFormularioClientes('<?php echo $rota;?>', null);" 
	                		class="btn btn-sm btn-success">
	                	    <i class="fas fa-plus"></i>
	                        Novo
	                    </button>
	                </th>
	            </tr>
	        </thead>
	        <tbody>
	        	<?php foreach ($clientes as $cliente):?>
		            <tr>
		            	<td><?php echo $cliente->nome;?></td>
		            	<td><?php echo $cliente->email;?></td>
		            	<td><?php echo $cliente->descricaoClienteTipo;?></td>
		             
		            	<td>
		            		<?php
		            		echo ! is_null($cliente->descricaoSegmento) ? 
		            		$cliente->descricaoSegmento : "<small>Não consta</small>"; 
		            		?>
		            	</td>

		                <td style="text-align:right">
		                	<div class="btn-group" role="group">
							    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							      <i class="fas fa-cogs"></i>
							    </button>
							    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

							    	<button class="dropdown-item" href="#" 
								      onclick="modalFormularioClientes('<?php echo $rota;?>', '<?php echo $cliente->id;?>')">
								      	<i class="fas fa-edit"></i> Editar
								    </button>

							        <a class="dropdown-item"  
							        href="<?php echo BASEURL;?>/ClienteEndereco/index/<?php echo in64($cliente->id);?>">
							        	<i class="fas fa-map-marker-alt"></i> Endereços
							        </a>

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
    'id' => 'modalClientes', 
    'width' => 'modal-lg',
    'title' => 'Cadastrar Clientes'
]);?>

<div id="formulario"></div>

<?php Modal::stop();?>

<script>
	function modalFormularioClientes(rota, id) {
        var url = "";
      
        if (id) {
            url = rota + "/" + id;
        } else {
            url = rota;
        }
        
        $("#formulario").html("<center><h3>Carregando...</h3></center>");
        $("#modalClientes").modal({backdrop: 'static'});
        $("#formulario").load(url);
    }

    
	function selecionarTipoDeCliente(item) {
		var tipo = item.value;
		if (tipo == 1) {
			$("#cnpj").attr('disabled','disabled');
			$("#id_cliente_segmento").attr('disabled','disabled');
			$("#cpf").attr('disabled', false);
		} else if (tipo == 2) {
			$("#cnpj").attr('disabled', false);
			$("#id_cliente_segmento").attr('disabled', false);
			$("#cpf").attr('disabled', 'disabled');
		}
	}

</script>
