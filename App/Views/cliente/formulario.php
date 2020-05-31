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
		        <label for="email">E-mail * <span class="label-email"></span></label>
		        <input type="text" class="form-control" name="email" id="email" placeholder="Digite o e-mail!" 
		        value="<?php echo isset($cliente->id) ? $cliente->email : ''?>"
		        onchange="verificaSeEmailExiste(this)">
		    </div>
		</div>


		<div class="col-md-4">
		    <div class="form-group">
		        <label for="password">Pessoa Física ou Jurídica *</label>
		        <select class="form-control" name="id_cliente_tipo" id="id_cliente_tipo"
		        onchange="selecionarTipoDeCliente(this)"> 
		        	<option value="selecione">Selecione</option>
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
		        <label for="password">Segmento *</label>
		        <select class="form-control" name="id_cliente_segmento" id="id_cliente_segmento"> 
		        	<option value="selecione">Selecione</option>
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
		        <label for="cnpj">CNPJ * <span class="label-cnpj"></span></label>
		        <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="Digite o CNPJ" 
		        value="<?php echo isset($cliente->id) ? $cliente->cnpj : ''?>"
		        onchange="verificaSeCnpjExiste(this)">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="cpf">CPF * <span class="label-cpf"></span></label>
		        <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite o CPF" 
		        value="<?php echo isset($cliente->id) ? $cliente->cpf : ''?>"
		        onchange="verificaSeCpfExiste(this)">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="telefone">Telefone</label>
		        <input type="text" class="form-control" name="telefone" id="telefone" 
		        placeholder="Digite o número de Telefone" 
		        value="<?php echo isset($cliente->id) ? $cliente->telefone : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="celular">Celular</label>
		        <input type="text" class="form-control" name="celular" id="celular" 
		        placeholder="Digite o número de Celular" 
		        value="<?php echo isset($cliente->id) ? $cliente->celular : ''?>">
		    </div>
		</div>


    </div><!--end row-->

	<button type="submit" class="btn btn-success btn-sm button-salvar-clientes" style="float:right"
	onclick="return salvarClientes()">
		<i class="fas fa-save"></i> Salvar
	</button>

</form>

<script src="<?php echo BASEURL;?>/public/js/maskedInput.js"></script>
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

    function selecionarTipoDeCliente(item) {
		var tipo = item.value;
		if (tipo == 1) {
			$("#cnpj").attr('disabled','disabled');
            
            /*
            Se verificou que CNPJ existe, mas depois trocou de pessoa juridica para pessoa fisica, 
            desfaz as mudanças imposta sobre os elementos do formulario em consequencia do CNPJ existente.
            */
			if ($("#cnpj").val() != '') {
				$("#cnpj").val('');
				$('.button-salvar-clientes').attr('disabled', false);
				$('.label-cnpj').html('');
			}

			if ($("#cpf").val() != '') {
				$("#cpf").val('');
				$('.button-salvar-clientes').attr('disabled', false);
				$('.label-cpf').html('');
			}
			
			$("#id_cliente_segmento").attr('disabled','disabled');
			$("#cpf").attr('disabled', false);
		} else if (tipo == 2) {
			$("#cnpj").attr('disabled', false);
			$("#id_cliente_segmento").attr('disabled', false);
			$("#cpf").attr('disabled', 'disabled');
		}
	}

    jQuery(function($){
	    jQuery("#cnpj").mask("99.999.999/9999-99");
	    jQuery("#cpf").mask("999.999.999-99");
	    jQuery("#telefone").mask("(99) 9999-9999");
	    jQuery("#celular").mask("(99) 99999-9999");
	});

	function salvarClientes() {
    	if ($('#nome').val() == '') {
			modalValidacao('Validação', 'Campo (Nome) deve ser preenchido!');
			return false;

		} else if ($('#email').val() == '') {
			modalValidacao('Validação', 'Campo (Email) deve ser preenchido!');
			return false;

		} else if ($('#id_cliente_tipo').val() == 'selecione') {
			modalValidacao('Validação', 'Este cliente é Pessoa Física ou Jurídica?');
			return false;

		} else if ($('#id_cliente_segmento').val() == 'selecione') {
			modalValidacao('Validação', 'Qual o segmento deste cliente?');
			return false;

		} 

	    return true;
    }

    function verificaSeEmailExiste(email) {
    	var rota = getDomain()+"/cliente/verificaSeEmailExiste/"+in64(email.value);
    	$.get(rota, function(data, status) {
    		var retorno = JSON.parse(data);
    		if (retorno.status == true) {
    			modalValidacao('Validação', 'Este Email já existe! Por favor, informe outro!');
    			$('.button-salvar-clientes').attr('disabled', 'disabled');
    			$('.label-email').html('<small style="color:#cc0000!important">Este Email já existe!</small>');
    		} else {
    			$('.button-salvar-clientes').attr('disabled', false);
    			$('.label-email').html('');
    		}
    	});
    }

    function verificaSeCnpjExiste(cnpj) {
		var rota = getDomain()+"/cliente/verificaSeCnpjExiste/"+in64(cnpj.value);
    	$.get(rota, function(data, status) {
    		var retorno = JSON.parse(data);
    		if (retorno.status == true) {
    			modalValidacao('Validação', 'Este CNPJ já existe! Por favor, informe outro!');
    			$('.button-salvar-clientes').attr('disabled', 'disabled');
    			$('.label-cnpj').html('<small style="color:#cc0000!important">Este CNPJ já existe!</small>');
    		} else {
    			$('.button-salvar-clientes').attr('disabled', false);
    			$('.label-cnpj').html('');
    		}
    	});
    }

    function verificaSeCpfExiste(cpf) {
		var rota = getDomain()+"/cliente/verificaSeCpfExiste/"+in64(cpf.value);
    	$.get(rota, function(data, status) {
    		var retorno = JSON.parse(data);
    		if (retorno.status == true) {
    			modalValidacao('Validação', 'Este CPF já existe! Por favor, informe outro!');
    			$('.button-salvar-clientes').attr('disabled', 'disabled');
    			$('.label-cpf').html('<small style="color:#cc0000!important">Este CPF já existe!</small>');
    		} else {
    			$('.button-salvar-clientes').attr('disabled', false);
    			$('.label-cpf').html('');
    		}
    	});
    }
</script>