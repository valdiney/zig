<style>
	label {
		width:100%;
		background:#d7dce1;
		border-radius:10px;
		padding:3px;
		border:1px solid #dee2e6;
	}
	label:hover {
		opacity:0.80;
	}

	.labelActive {
		background:#ccffcc;
	}
	
</style>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-user-lock"></i> 
	            Permissões
	        </h5>
	    </div>

		<table id="example" class="table tabela-ajustada table-striped" style="width:100%">
	        <thead>
	            <tr>
	            	<th>#</th>
	                <th>Modulo</th>
	                <th>Consultar</th>
	                <th>Criar</th>
	                <th>Editar</th>
	                <th>Excluír</th>
	            </tr>
	        </thead>
	        <tbody>
	        	<?php foreach ($usuarioModulos as $modulo):?>
		            <tr>
		            	<td><i class="fas fa-charging-station"></i></td>
		            	<td><?php echo $modulo->nomeModulo;?></td>
		            	<td>
		            		<label for="conultar_<?php echo $modulo->idUsuarioModulo;?>" 
		            			class="radio-options label_checkbox 
		            			<?php echo ($modulo->consultar == 1) ? 'labelActive' : false;?>">
		                		<input type="checkbox" name="consultar" 
		                		id="conultar_<?php echo $modulo->idUsuarioModulo;?>"
		                		<?php echo ($modulo->consultar == 1) ? 'checked' : false;?>>
	                	    </label>
		            	</td>

		            	<td>
		            		<label for="criar_<?php echo $modulo->idUsuarioModulo;?>" 
		            			class="radio-options label_checkbox 
		            			<?php echo ($modulo->criar == 1) ? 'labelActive' : false;?>">
		                		<input type="checkbox" name="consultar" 
		                		id="criar_<?php echo $modulo->idUsuarioModulo;?>"
		                		<?php echo ($modulo->criar == 1) ? 'checked' : false;?>>
	                	    </label>
		            	</td>

		            	<td>
		            		<label for="editar_<?php echo $modulo->idUsuarioModulo;?>" 
		            			class="radio-options label_checkbox 
		            			<?php echo ($modulo->editar == 1) ? 'labelActive' : false;?>">
		                		<input type="checkbox" name="consultar" 
		                		id="editar_<?php echo $modulo->idUsuarioModulo;?>"
		                		<?php echo ($modulo->editar == 1) ? 'checked' : false;?>>
	                	    </label>
		            	</td>

		            	<td>
		            		<label for="excluir_<?php echo $modulo->idUsuarioModulo;?>" 
		            			class="radio-options label_checkbox 
		            			<?php echo ($modulo->excluir == 1) ? 'labelActive' : false;?>">
		                		<input type="checkbox" name="consultar" 
		                		id="excluir_<?php echo $modulo->idUsuarioModulo;?>"
		                		<?php echo ($modulo->excluir == 1) ? 'checked' : false;?>>
	                	    </label>
		            	</td>
		                
		            </tr>
	           <?php endforeach;?>
	        <tfoot></tfoot>
	    </table>

    <br>
	
   </div>
</div>

<script src="<?php echo BASEURL;?>/public/assets/js/core/jquery.min.js"></script>
<script>
	$(function() {
		
		$('.label_checkbox input').each(function(item, value) {
			var status = null;
			$(this).click(function() {
				if (value.checked == true) {
					status = false;
					$(this).parent().addClass('labelActive');
				} else {
					status = true;
					$(this).parent().removeClass('labelActive');
				}
			});
		});
	});
</script>
