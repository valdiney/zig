<form method="post" action="<?php echo isset($cliente->id) ? BASEURL.'/cliente/update' : BASEURL.'/cliente/save';?>"
	enctype='multipart/form-data'>
	<div class="row">

		<?php if (isset($cliente->id)):?>
			<input type="hidden" name="id" value="<?php echo $cliente->id;?>">
		<?php endif;?>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="nome">Nome / Razão social *</label>
		        <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome do cliente!" 
		        value="<?php echo isset($cliente->id) ? $cliente->nome : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="email">E-mail *</label>
		        <input type="text" class="form-control" name="email" id="email" placeholder="Digite o e-mail!" 
		        value="<?php echo isset($cliente->id) ? $cliente->email : ''?>">
		    </div>
		</div>


		<div class="col-md-4">
		    <div class="form-group">
		        <label for="password">Pessoa Física ou Jurídica *</label>
		        <select class="form-control" name="id_cliente_tipo" id="id_cliente_tipo"
		        onchange="selecionarTipoDeCliente(this)"> 
		        	<option>Selecione</option>
		        	<?php foreach ($clientesTipos as $clienteTipo):?>
		        		<?php if (isset($cliente->id) && $cliente->id_cliente_tipo == $clienteTipo->id):?>
		        		    <option value="<?php echo $cliente->id_cliente_tipo;?>" 
		        		    	selected="selected"><?php echo $clienteTipo->descricao;?>	
		        		    </option>
		        		<?php else:?>
		        		    <option value="<?php echo $clienteTipo->id;?>"><?php echo $clienteTipo->descricao;?></option>
		        	    <?php endif;?>
		        	<?php endforeach;?>
		        </select>
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="password">Segmento da Empresa *</label>
		        <select class="form-control" name="id_cliente_segmento" id="id_cliente_segmento"> 
		        	<option>Selecione</option>
		        	<?php foreach ($clientesSegmentos as $clienteSegmento):?>
		        		<?php if (isset($cliente->id) && $cliente->id_cliente_segmento == $clienteSegmento->id):?>
		        		    <option value="<?php echo $cliente->id_cliente_segmento;?>" 
		        		    	selected="selected"><?php echo $clienteSegmento->descricao;?>	
		        		    </option>
		        		<?php else:?>
		        		    <option value="<?php echo $clienteSegmento->id;?>">
		        		    	<?php echo $clienteSegmento->descricao;?>	
		        		    </option>
		        	    <?php endif;?>
		        	<?php endforeach;?>
		        </select>
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="cnpj">CNPJ *</label>
		        <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="Digite o CNPJ" 
		        value="<?php echo isset($cliente->id) ? $cliente->cnpj : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="cpf">CPF *</label>
		        <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite o CPF" 
		        value="<?php echo isset($cliente->id) ? $cliente->cpf : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="telefone">Telefone *</label>
		        <input type="text" class="form-control" name="telefone" id="telefone" 
		        placeholder="Digite o número de Telefone" 
		        value="<?php echo isset($cliente->id) ? $cliente->telefone : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="celular">Celular *</label>
		        <input type="text" class="form-control" name="celular" id="celular" 
		        placeholder="Digite o número de Celular" 
		        value="<?php echo isset($cliente->id) ? $cliente->celular : ''?>">
		    </div>
		</div>


    </div><!--end row-->

	<button type="submit" class="btn btn-success btn-sm" style="float:right">
		<i class="fas fa-save"></i> Salvar
	</button>

</form>

<script>
	
	<?php if (isset($cliente->id)):?>
		<?php if ($cliente->id_cliente_tipo == 1):?>

			$("#cnpj").attr('disabled','disabled');
			$("#id_cliente_segmento").attr('disabled','disabled');
			$("#cpf").attr('disabled', false);

		<?php elseif ($cliente->id_cliente_tipo == 2):?>

			$("#cnpj").attr('disabled', false);
			$("#id_cliente_segmento").attr('disabled', false);
			$("#cpf").attr('disabled', 'disabled');

		<?php endif;?>
    <?php endif;?>
	
</script>