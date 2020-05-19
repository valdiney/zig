<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fab fa-product-hunt" style="color:#99ccff"></i> Produtos</h5>
            
            <form method="post" action="<?php echo BASEURL;?>/venda/save">
		        <div class="row">
	                
		        	<div class="col-md-2">
					    <div class="form-group">
					        <label for="valor">R$ Valor *</label>
					        <input type="text" class="form-control campo-moeda valor" name="valor" id="valor" 
					        placeholder="00,00">
					    </div>
				    </div>

				    <div class="col-md-3">
					    <div class="form-group">
					        <label for="id_meio_pagamento">Meios de pagamento *</label>
					        <select class="form-control" name="id_meio_pagamento" id="id_meio_pagamento">
					        	
					        </select>
					    </div>
				    </div>

				    <div class="col-md-3">
					    <div class="form-group">
					        <label for="id_usuario">Vendedor *</label>
					        <select class="form-control" name="id_usuario" id="id_usuario">
					        	
					        </select>
					    </div>
				    </div>

			    	<div class="col-md-1">
			    		<button type="submit" class="btn btn-success text-right salvar-venda" id="salvar-venda">
						    <i class="fas fa-save"></i> Salvar
					    </button>
			    	</div>
		        </div>
		    </form>

	    </div>
   </div>

</div>
