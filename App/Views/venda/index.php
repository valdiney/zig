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
     }
	.card-produtos img {
		width:100px;
	    height:100px;
	    object-fit:cover;
	    object-position:center;
	    margin:0 auto;
	    display:block;
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
		width:100px;
		text-align:center;
	}
</style>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fab fa-product-hunt" style="color:#99ccff"></i> Produtos</h5>
            
            
            <div class="row div-inter-produtos">

            	<div class="col-lg-2 card-produtos" onclick="colocarProdutosNaMesa(1)">
            		<img src="https://www.ovale.com.br/_midias/jpg/2020/01/20/acai-883535.jpg">
            		<center><span class="produto-titulo">AÇAÍ TRADICIONAL</span></center>
            		<center><span class="produto-valor">R$ 20,00</span></center>
            	</div>

            	<div class="col-lg-2 card-produtos" onclick="colocarProdutosNaMesa(2)">
            		<img src="https://www.supermercadosrondon.com.br/guiadecarnes/images/postagens/quer_fazer_hamburger_artesanal_perfeito_2019-05-14.jpg">
            		<center><span class="produto-titulo">HAMBÚRGUER</span></center>
            		<center><span class="produto-valor">R$ 30,00</span></center>
            	</div>

            	<div class="col-lg-2 card-produtos" onclick="colocarProdutosNaMesa(3)">
            		<img src="https://www.supermercadosrondon.com.br/guiadecarnes/images/postagens/receita_facil_de_estrogonofe_de_carne_2019-05-21.jpg">
            		<center><span class="produto-titulo">ESTROGONOFE</span></center>
            		<center><span class="produto-valor">R$ 25,50</span></center>
            	</div>

            	<div class="col-lg-2 card-produtos">
            		<img src="https://www.supermercadosrondon.com.br/guiadecarnes/images/postagens/as_7_melhores_carnes_para_churrasco_21-05-2019.jpg">
            		<center><span class="produto-titulo">CARNE CHURRASCO</span></center>
            		<center><span class="produto-valor">R$ 18,15</span></center>
            	</div>

            	<div class="col-lg-2 card-produtos">
            		<img src="https://cd.shoppub.com.br/cenourao/media/cache/7d/f4/7df4d5eff3efae9299961f143e281750.jpg">
            		<center><span class="produto-titulo">GUARANÁ ANTÁRCTICA</span></center>
            		<center><span class="produto-valor">R$ 3,49</span></center>
            	</div>

            	<div class="col-lg-2 card-produtos">
            		<img src="https://cd.shoppub.com.br/cenourao/media/cache/da/72/da726fa39f4f96fb59233dee32714d07.jpg">
            		<center><span class="produto-titulo">REFRIGERANTE ZERO COCA-COLA</span></center>
            		<center><span class="produto-valor">R$ 3,99</span></center>
            	</div>
            	
            </div>
		     

	    </div>
   </div>

</div>

<div class="row">

	<div class="card col-lg-10 content-div">
		<div class="card-body">
	        <h5 class="card-title">
	        	<i class="fas fa-piggy-bank" style="color:#00cc99"></i> 
	        	Produtos selecionados
	        </h5>
            
            
		    <table class="table tabela-ajustada tabela-de-produto" style="width:100%">
		        <thead>
		            <tr>
		            	<th>#</th>
		                <th>Nome</th>
		                <th>R$ Preço</th>
		                <th>Quantidade</th>
		                <th>Total</th>
		                <th>Ação</th>
		            </tr>
		        </thead>
		     <tbody>
		     	
		     </tbody>
	        	
	        <tfoot></tfoot>
	    </table>

	    </div>
   </div>

   <div class="card col-lg-2 content-div">
		<div class="card-body">

			<center>
				<span>Total:</span> <br>
			<span><b>R$ 100,00</b></span>
			</center>
	        
            <button class="btn btn-sm btn-success">
	            Confirmar    	   
	        </button>

	    </div>
   </div>

</div>

<script src="<?php echo BASEURL;?>/public/assets/js/core/jquery.min.js"></script>
<script src="<?php echo BASEURL;?>/public/js/helpers.js"></script>
<script src="<?php echo BASEURL;?>/public/js/venda/funcoesPdvAvancado.js"></script>

<script type="text/javascript">
	$(function() {
		$('.salvar-venda').click(function() {

			if ($('.valor').val() == '') {
				modalValidacao('Validação', 'Campo (Valor) deve ser preenchido!');
				return false;
			}

			return true;

		});
	});
</script>