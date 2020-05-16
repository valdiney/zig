<?php use System\Session\Session; ?>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title">Vendas por período!</h5>
	    </div>

	    <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="periodo_de">Período de</label>
                    <input type="date" class="form-control" name="periodo_de" id="periodo_de"
                    value="<?php echo date('Y').'-'.date('m').'-'.'01'?>">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="periodo_ate">Período até</label>
                    <input type="date" class="form-control" name="periodo_ate" id="periodo_ate"
                    value="<?php echo date('Y-m-d')?>">
                </div>
            </div>

            <div class="col-md-3">
			    <div class="form-group">
			        <label for="id_usuario">Vendedor *</label>
			        <select class="form-control" name="id_usuario" id="id_usuario">
			        	<?php foreach ($usuarios as $usuario):?>
			        		<?php if ($usuario->id == Session::get('idUsuario')):?>	
			        			<option value="<?php echo $usuario->id;?>" selected>
			        			    <?php echo $usuario->nome;?>
			        		    </option>
			        		<?php else:?>
				        		<option value="<?php echo $usuario->id;?>">
				        			<?php echo $usuario->nome;?>
				        		</option>
				        	<?php endif;?>
			        	<?php endforeach;?>
			        </select>
			    </div>

			    <button type="submit" class="btn btn-sm btn-success text-right pull-right" id="salvar-venda">
			         <i class="fas fa-search"></i> Buscar
		        </button>
		    </div>
        </div><!--end row-->

    <br>
	
   </div>
</div>


<div class="row">

	<div class="card col-lg-12 content-div">

		<table id="example" class="display table" style="width:100%">
	        <thead>
	            <tr>
	                <th>Nome</th>
	                <th>Entrada</th>
	                <th>Inicio intervalo</th>
	                <th>Fim intervalo</th>
	                <th>Saida</th>
	                <th>Data</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td>Tiger Nixon</td>
	                <td>System Architect</td>
	                <td>Edinburgh</td>
	                <td>61</td>
	                <td>2011/04/25</td>
	                <td>$320,800</td>
	            </tr>
	            <tr>
	                <td>Garrett Winters</td>
	                <td>Accountant</td>
	                <td>Tokyo</td>
	                <td>63</td>
	                <td>2011/07/25</td>
	                <td>$170,750</td>
	            </tr>
	            <tr>
	                <td>Ashton Cox</td>
	                <td>Junior Technical Author</td>
	                <td>San Francisco</td>
	                <td>66</td>
	                <td>2009/01/12</td>
	                <td>$86,000</td>
	            </tr>
	            <tr>
	                <td>Cedric Kelly</td>
	                <td>Senior Javascript Developer</td>
	                <td>Edinburgh</td>
	                <td>22</td>
	                <td>2012/03/29</td>
	                <td>$433,060</td>
	            </tr>
	            
	        <tfoot>
	            <!--<tr>
	                <th>Name</th>
	                <th>Position</th>
	                <th>Office</th>
	                <th>Age</th>
	                <th>Start date</th>
	                <th>Salary</th>
	            </tr>-->
	        </tfoot>
	    </table>
		

	

    <br>
	
   </div>
</div