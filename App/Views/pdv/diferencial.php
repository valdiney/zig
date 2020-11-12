<!--Usando o Html Components-->
<?php
use App\Views\Layouts\HtmlComponents\Modal;
use System\Session\Session;
?>
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
    .card-produtos {
     	margin-top:10px;
        border-left:1px solid #dddddd;
     	padding:0;
     	float:left;
     }
     .card-produtos img:hover {
     	cursor:pointer;
     	border:2px solid #7fe3ca;
     	filter: brightness(95%);
    }
     .card-produtos img:active {
     	cursor:pointer;
     	border:1px solid #7fe3ca;
     	box-shadow:silver 1px 1px 3px;
    }
	.card-produtos img {
		width:100px;
	    height:100px;
	    object-fit:cover;
	    object-position:center;
	    margin:0 auto;
	    display:block;
	    border-radius:50%;
	    border:1px solid gray;
	    padding:3px;
	    background:white;
	}
	.produto-titulo {
		font-size:11px!important;
		text-align:center;
		display:block;
		margin-top:3px;
	}
	.produto-valor {
		font-size:13px!important;
		text-align:center;
		font-weight:bold;
	}
	.div-inter-produtos {
		background:#f4f3ef;
	}
	.img-produto-seleionado {
		width:30px;
	    height:30px;
	    object-fit:cover;
	    object-position:center;
	    border-radius:50%;
	    border:1px solid #dee2e6;
	}
	.campo-quantidade {
		border:1px solid #dee2e6;
		width:50px;
		text-align:center;
	}
	.div-inter-produtos {
		overflow-y: scroll;
		height:160px;
		padding-bottom:10px;
	}
	.div-inter-produtos::-webkit-scrollbar-track {
        background-color:white;
    }
    .div-inter-produtos::-webkit-scrollbar {
        width: 3px;
        background:#f0f4f7;
    }
    .div-inter-produtos::-webkit-scrollbar-thumb {
        background:#d0d9e1;
    }
    .div-inter-produtos::-webkit-input-placeholder {
        color: #8198ac;
    }
</style>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-box-open"></i> Produtos</h5>

            <div class="row div-inter-produtos">
                <?php foreach ($produtos as $key => $produto):?>
	            	<div class="col-lg-2 card-produtos"
	            	onclick="colocarProdutosNaMesa('<?php echo $produto->id;?>', this)">
	            		<img src="<?php echo BASEURL .'/'. $produto->imagem;?>" title="Adicionar!">
	            		<center><span class="produto-titulo"><?php echo mb_strtoupper($produto->nome);?></span></center>
	            		<center><span class="produto-valor">R$ <?php echo real($produto->preco);?></span></center>
	            	</div>
                <?php endforeach;?>
            </div><!--div-inter-produtos-->

	    </div>
   </div>

</div>

<div class="row">

	<div class="card col-lg-9 content-div">
		<div class="card-body" style="overflow-x:auto!important;">
	        <h5 class="card-title">
	        	<i class="fas fa-box-open"></i>
	        	Selecionados
	        </h5>

		    <table class="table tabela-ajustada tabela-de-produto" style="width:100%;">
		        <thead>
		            <tr>
		            	<th>#</th>
		                <th>Produto</th>
		                <th class="hidden-when-mobile">Preço</th>
		                <th>QTD</th>
		                <th>Total</th>
		                <th>Ação</th>
		            </tr>
		        </thead>
		        <tbody></tbody>
	            <tfoot></tfoot>
	        </table>
	    </div>
   </div>

   <div class="card col-lg-3 content-div" style="background:transparent;box-shadow:none;padding-right:0">
		<div class="card-body" style="background:white;border-radius:10px;box-shadow:#deddd9 1px 2px 10px">
			<center>
				<span>Total:</span> <br>
			    <span><b class="b-mostra-valor-total">R$ 00,00</b></span>
			</center>
		    <hr>
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

            <button class="btn btn-sm btn-success btn-block" onclick="saveVendasViaSession('<?php echo TOKEN;?>')">
	            <i class="fas fa-save"></i> Confirmar
	        </button>
	    </div>
   </div>

</div><!--end row-->

<script src="<?php echo BASEURL;?>/public/assets/js/core/jquery.min.js"></script>
<script src="<?php echo BASEURL;?>/public/js/helpers.js"></script>
<script src="<?php echo BASEURL;?>/public/js/venda/funcoesPdvAvancado.js"></script>
