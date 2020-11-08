<form method="post" action="<?php echo isset($produto->id) ? BASEURL.'/produto/update' : BASEURL.'/produto/save';?>"
	enctype='multipart/form-data'>
	<div class="row">

		<input type="hidden" name="_token" value="<?php echo TOKEN; ?>" />

		<?php if (isset($produto->id)):?>
			<input type="hidden" name="id" value="<?php echo $produto->id;?>">
		<?php endif;?>

		<input type="hidden" name="id_empresa" value="1">

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="nome">Nome *</label>
		        <input type="text" class="form-control nome" name="nome" id="nome"
		        placeholder="Digite o nome do produto!"
		        value="<?php echo isset($produto->id) ? $produto->nome : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="preco">R$ Preço *</label>
		        <input type="text" class="form-control campo-moeda" name="preco" id="preco" placeholder="00,00"
		        value="<?php echo isset($produto->preco) ? real($produto->preco) : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="imagem">Escolher Imagem do Produto</label>
		        <input type="file" class="form-control" name="imagem" id="imagem"> <br>
		        <?php if (isset($produto->id)):?>
		             <img src="<?php echo BASEURL.'/'.$produto->imagem;?>" class="imagem-produto">
		        <?php else:?>
		        	 <i class="fas fa-box-open" style="font-size:40px"></i>
		        <?php endif;?>
		    </div>
		</div>

		<div class="col-md-12">
		    <div class="form-group">
		        <label for="descricao">Descrição</label>
		        <textarea class="form-control" name="descricao" id="descricao" placeholder="Deixe uma descrição do Produto!"><?php echo isset($produto->id) ? $produto->descricao : '';?></textarea>
		    </div>
		</div>

    </div><!--end row-->

	<button type="submit" class="btn btn-success btn-sm" style="float:right"
	onclick="return salvarProduto()">
		<i class="fas fa-save"></i> Salvar
	</button>
</form>

 <script>
    $(function() {
        jQuery('.campo-moeda')
        .maskMoney({
          prefix:'R$ ',
          allowNegative: false,
          thousands:'.', decimal:',',
          affixesStay: false
        });
    });
 </script>
