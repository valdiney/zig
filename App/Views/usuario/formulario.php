<form method="post" action="<?php echo isset($usuario->id) ? BASEURL.'/usuario/update' : BASEURL.'/usuario/save';?>"
	enctype='multipart/form-data'>
	<div class="row">

		<?php if (isset($usuario->id)):?>
			<input type="hidden" name="id" value="<?php echo $usuario->id;?>">
		<?php endif;?>

		<input type="hidden" name="id_cliente" value="1">

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="nome">Nome *</label>
		        <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome do usuário!" 
		        value="<?php echo isset($usuario->id) ? $usuario->nome : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="email">E-mail *</label>
		        <input type="text" class="form-control" name="email" id="email" placeholder="Digite o e-mail de acesso!" 
		        value="<?php echo isset($usuario->id) ? $usuario->email : ''?>">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="password">Senha *</label>
		        <input type="password" class="form-control" name="password" id="password" placeholder="Digite a senha" 
		        value="">
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="password">Sexo *</label>
		        <select class="form-control" name="id_sexo" id="id_sexo"> 
		        	<option>Selecione...</option>
		        	<?php foreach ($sexos as $sexo):?>
		        		<?php if (isset($usuario->id) && $usuario->id_sexo == $sexo->id):?>
		        		    <option value="<?php echo $usuario->id_sexo;?>" 
		        		    	selected="selected"><?php echo $sexo->descricao;?>	
		        		    </option>
		        		<?php else:?>
		        		    <option value="<?php echo $sexo->id;?>"><?php echo $sexo->descricao;?></option>
		        	    <?php endif;?>
		        	<?php endforeach;?>
		        </select>
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="password">Perfis *</label>
		        <select class="form-control" name="id_perfil" id="id_perfil"> 
		        	<option>Selecione...</option>
		        	<?php foreach ($perfis as $perfil):?>
		        		<?php if (isset($usuario->id) && $usuario->id_perfil == $perfil->id):?>
		        		    <option value="<?php echo $usuario->id_perfil;?>" 
		        		    	selected="selected"><?php echo $perfil->descricao;?>	
		        		    </option>
		        		<?php else:?>
		        		    <option value="<?php echo $perfil->id;?>"><?php echo $perfil->descricao;?></option>
		        	    <?php endif;?>
		        	<?php endforeach;?>
		        </select>
		    </div>
		</div>

		<div class="col-md-4">
		    <div class="form-group">
		        <label for="imagem">Escolher Imagem de Perfil</label>
		        <input type="file" class="form-control" name="imagem" id="imagem"> <br>
		        <?php if (isset($usuario->id)):?>
		             <img src="<?php echo $usuario->imagem;?>" class="perfil">
		        <?php else:?>
		        	 <i class="fas fa-user" style="font-size:40px"></i>
		        <?php endif;?>
		    </div>
		</div>

    </div><!--end row-->

	<button type="submit" class="btn btn-success btn-sm" style="float:right">
		<i class="fas fa-save"></i> Salvar
	</button>
</form>