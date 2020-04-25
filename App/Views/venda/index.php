<!--Usando o Html Components-->
<?php use App\Views\Layouts\HtmlComponents\Modal;?>

<style type="text/css">
	.imagem-perfil {
		width:30px;
	    height:30px;
	    object-fit:cover;
	    object-position:center;
	    border-radius:50%;
	}

	@media only screen and (min-width: 600px) {
	  #salvar-venda {
	  	margin-top:25px;
	  }
	}

	.card-two {
		margin-top:10px;
		border-radius:3px;
		box-shadow:none;
		border:1px solid #dddddd;
		padding-left:3px;
		padding-right:3px;
	}

	.tabela-ajustada tr td {
		padding-top:2px!important;
		padding-bottom:2px!important;
		font-size:12px;
	}
	.tabela-ajustada th {
		font-size:13px!important;

	}
</style>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-piggy-bank" style="color:#00cc99"></i> Registrar Venda</h5>
            
            <form method="post" action="<?php echo BASEURL;?>/venda/save">
		        <div class="row">
	                
		        	<div class="col-md-2">
					    <div class="form-group">
					        <label for="valor">R$ Valor *</label>
					        <input type="text" class="form-control" name="valor" id="valor" placeholder="00,00">
					    </div>
				    </div>

				    <div class="col-md-3">
					    <div class="form-group">
					        <label for="id_meio_pagamento">Meios de pagamento *</label>
					        <select class="form-control" name="id_meio_pagamento" id="id_meio_pagamento">
					        	<?php foreach ($meiosPagamentos as $pagamento):?>
					        		<option value="<?php echo $pagamento->id;?>">
					        			<?php echo $pagamento->legenda;?>
					        		</option>
					        	<?php endforeach;?>
					        </select>
					    </div>
				    </div>

				    <div class="col-md-3">
					    <div class="form-group">
					        <label for="id_usuario">Vendedor *</label>
					        <select class="form-control" name="id_usuario" id="id_usuario">
					        	<?php foreach ($usuarios as $usuario):?>
					        		<option value="<?php echo $usuario->id;?>"><?php echo $usuario->nome;?></option>
					        	<?php endforeach;?>
					        </select>
					    </div>
				    </div>

			    	<div class="col-md-1">
			    		<button type="submit" class="btn btn-success text-right" id="salvar-venda">
						    <i class="fas fa-save"></i> Salvar
					    </button>
			    	</div>
		        </div>
		    </form>

	    </div>
   </div>

</div>



<div class="row">
		<div class="card card-two col-lg-6 content-div">
			<div class="card-body">
		        <h5 class="card-title"><i class="fas fa-cart-arrow-down" style="color:#00cc99"></i> 
		            Ultimas 10 vendas de hoje!
		        </h5>

		        <table class="table tabela-ajustada">
		        	<thead>
		        		<tr>
		        			<th>#</th>
			        		<th>Valor</th>
			        		<th>Pagamento</th>
			        		<th>Hora</th>
		        		</tr>
		        	</thead>
		        	<tbody>
		        		<?php foreach($vendasGeralDoDia as $venda):?>
		        			<tr>
		        				<td><img class="imagem-perfil" src="<?php echo $venda->imagem;?>"></td>
		        				<td>R$ <?php echo number_format($venda->valor, 2,',','.');?></td>
		        				<td><?php echo $venda->legenda;?></td>
		        				<td><?php echo $venda->data;?>h</td>
		        			</tr>
		        		<?php endforeach;?>
		        	</tbody>
		        </table>
		    </div>
	   </div>

	   <div class="card card-two col-lg-6 content-div">
			<div class="card-body">
		        <h5 class="card-title"><i class="fas fa-cart-arrow-down" style="color:#00cc99"></i> 
		            Vendas realizadas
		        </h5>
		    </div>
	   </div>
</div>

<?php Modal::start([
    'id' => 'modalUsuarios', 
    'width' => 'modal-lg',
    'title' => 'Cadastrar Usuários'
]);?>

<div id="formulario"></div>

<?php Modal::stop();?>

<script>
	function modalUsuarios(rota, usuarioId) {
        var url = "";
      
        if (usuarioId) {
            url = rota + "/" + usuarioId;
        } else {
            url = rota;
        }
        
        $("#modalUsuarios").modal({backdrop: 'static'});
        load(url, 'formulario');
    }
</script>