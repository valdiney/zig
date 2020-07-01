<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-store"></i> Empresas</h5>
	    </div>

		<table id="example" class="table tabela-ajustada" style="width:100%">
	        <thead>
	            <tr>
	                <th>Nome</th>
	                <th>Data</th>
	                <th style="text-align:right;padding-right:0">
	                	<?php $rota = BASEURL.'/produto/modalFormulario';?>
	                	<button onclick="modalFormularioProdutos('<?php echo $rota;?>', null);" 
	                		class="btn btn-sm btn-success">
	                	    <i class="fas fa-plus"></i>
	                        Novo
	                    </button>
	                </th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                
	            </tr>
	        <tfoot></tfoot>
	    </table>

    <br>
	
   </div>
</div>