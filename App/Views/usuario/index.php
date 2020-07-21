<!--Usando o Html Components-->
<?php
use System\HtmlComponents\Modal\Modal;
use System\HtmlComponents\FlashMessage\FlashMessage;
use System\Session\Session;
use App\Config\ConfigPerfil;
?>

<style type="text/css">
	.imagem-perfil {
		width:40px;
	    height:40px;
	    object-fit:cover;
	    object-position:center;
	    border-radius:50%;
	}
</style>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-users"></i> Usuários</h5>
	    </div>
        <!-- Mostra as mensagens de erro-->
	    <?php FlashMessage::show();?>

        <?php if (count($usuarios) > 0):?>
	    <table id="example" class="table tabela-ajustada table-striped" style="width:100%">
	        <thead>
	            <tr>
	            	<th>#</th>
	                <th>Nome</th>
	                <th>E-mail</th>
	                <th>Perfil</th>
	                <th style="text-align:right;padding-right:0">
	                	<?php $rota = BASEURL.'/usuario/modalFormulario';?>
	                	<?php if (Session::get('idPerfil') != ConfigPerfil::vendedor()):?>
		                	<button onclick="modalUsuarios('<?php echo $rota;?>', false);"
		                		class="btn btn-sm btn-success">
		                	    <i class="fas fa-plus"></i>
		                        Novo
		                    </button>
	                    <?php endif;?>
	                </th>
	            </tr>
	        </thead>
	        <tbody>

	        	<?php foreach ($usuarios as $usuario):?>
		            <tr>
		            	<td>
		            		<?php if ( ! is_null($usuario->imagem) && $usuario->imagem != ''):?>
		            			<center>
		            				<img src="<?php echo $usuario->imagem;?>" width="40" class="imagem-perfil">
		            			</center>
		            		<?php else:?>
		            			<center><i class="fas fa-user" style="font-size:40px"></i></center>
		            		<?php endif;?>
		            	</td>
		                <td><?php echo $usuario->nome;?></td>
		                <td><?php echo $usuario->email;?></td>
		                <td><?php echo $usuario->perfil;?></td>
		                <td style="text-align:right">

						<div class="btn-group" role="group">
						    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						      <i class="fas fa-cogs"></i>
						    </button>
						    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

						      <button class="dropdown-item" href="#"
						      onclick="modalUsuarios('<?php echo $rota;?>', <?php echo $usuario->id;?>);">
						      	<i class="fas fa-edit"></i> Editar
						      </button>

						      <!--<a class="dropdown-item" href="#">
						      	<i class="fas fa-trash-alt" style="color:#cc6666"></i> Excluir
						      </a>-->

						    </div>
						  </div>
		                </td>
		            </tr>
	            <?php endforeach;?>
	        <tfoot></tfoot>
	    </table>
	    <?php else:?>
	    	<center>
	    		<i class="far fa-grin-beam" style="font-size:50px;opacity:0.60"></i> <br> <br>
	    	    Poxa, ainda não há nenhum Cliente cadastrado! <br>
	    	    <?php $rota = BASEURL.'/usuario/modalFormulario';?>
            	<button
            	onclick="modalUsuarios('<?php echo $rota;?>', null);"
            		class="btn btn-sm btn-success">
            	    <i class="fas fa-plus"></i>
                    Cadastrar Usuário
                </button>
	       </center>
		<?php endif;?>

    <br>

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
        $("#formulario").load(url);
    }
</script>
