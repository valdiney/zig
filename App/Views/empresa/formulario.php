<form method="post" action="<?php echo isset($empresa->id) ? BASEURL.'/empresa/update' : BASEURL.'/empresa/save';?>"
	enctype='multipart/form-data'>
	<div class="row">

		<?php if (isset($empresa->id)):?>
			<input type="hidden" name="id" value="<?php echo $empresa->id;?>">
		<?php endif;?>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="nome">Nome da Empresa *</label>
		        <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite aqui..." 
		        value="<?php echo isset($empresa->id) ? $empresa->nome : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="email">E-mail * <span class="label-email"></span></label>
		        <input type="text" class="form-control" name="email" id="email" placeholder="Digite o e-mail!" 
		        value="<?php echo isset($empresa->id) ? $empresa->email : ''?>"
		        onchange="verificaSeEmailExiste(this, <?php echo isset($empresa->id) ? $empresa->id : false;?>)">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="telefone">Telefone</label>
		        <input type="text" class="form-control" name="telefone" id="telefone" 
		        placeholder="Digite o número de Telefone" 
		        value="<?php echo isset($empresa->id) ? $empresa->telefone : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="celular">Celular</label>
		        <input type="text" class="form-control" name="celular" id="celular" 
		        placeholder="Digite o número de Celular" 
		        value="<?php echo isset($empresa->id) ? $empresa->celular : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="id_segmento">Segmento *</label>
		        <select class="form-control" name="id_segmento" id="id_segmento"> 
		        	<option value="selecione">Selecione</option>
		        	<?php foreach ($segmentos as $segmento):?>
		        		<?php if (isset($empresa->id) && $empresa->id_segmento == $segmento->id):?>
		        		    <option value="<?php echo $empresa->id_segmento;?>" 
		        		    	selected="selected"><?php echo $segmento->descricao;?>	
		        		    </option>
		        		<?php else:?>
		        		    <option value="<?php echo $segmento->id;?>">
		        		    	<?php echo $segmento->descricao;?>	
		        		    </option>
		        	    <?php endif;?>
		        	<?php endforeach;?>
		        </select>
		    </div>
		</div>

    </div><!--end row-->

	<button type="submit" class="btn btn-success btn-sm button-salvar-clientes" style="float:right"
	onclick="return salvarClientes()">
		<i class="fas fa-save"></i> Salvar
	</button>

</form>