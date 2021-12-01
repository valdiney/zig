<?php use System\Session\Session; ?>
<form method="post"
      action="<?php echo isset($usuario->id) ? BASEURL . '/usuario/update' : BASEURL . '/usuario/save'; ?>"
      enctype='multipart/form-data'>
    <!-- token de segurança -->
    <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

    <div class="row">

        <?php if (isset($usuario->id)) : ?>
            <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
        <?php endif; ?>

        <input type="hidden" name="id_empresa" value="<?php echo Session::get('idEmpresa'); ?>">

        <div class="col-md-4">
            <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome do usuário!"
                       value="<?php echo isset($usuario->id) ? $usuario->nome : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="email">E-mail *</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Digite o e-mail de acesso!"
                       value="<?php echo isset($usuario->id) ? $usuario->email : '' ?>"
                       onchange="verificaSeEmailExiste(this, <?php echo isset($usuario->id) ? $usuario->id : false; ?>)">
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
                    <option value="selecione">Selecione...</option>
                    <?php foreach ($sexos as $sexo) : ?>
                        <?php if (isset($usuario->id) && $usuario->id_sexo == $sexo->id) : ?>
                            <option value="<?php echo $usuario->id_sexo; ?>"
                                    selected="selected"><?php echo $sexo->descricao; ?>
                            </option>
                        <?php else : ?>
                            <option value="<?php echo $sexo->id; ?>"><?php echo $sexo->descricao; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!--
          Se o usuario logado for o mesmo que será editado, não mostra o campo de perfis porque
          um usuario não deve mudar o seu proprio perfil de usuario.
        -->

        <div class="col-md-4">
            <div class="form-group">
                <label for="password">Perfis *</label>
                <select class="form-control" name="id_perfil" id="id_perfil">
                    <option value="selecione">Selecione...</option>
                    <?php foreach ($perfis as $perfil) : ?>
                        <?php if (isset($usuario->id) && $usuario->id_perfil == $perfil->id) : ?>
                            <option value="<?php echo $usuario->id_perfil; ?>"
                                    selected="selected"><?php echo $perfil->descricao; ?>
                            </option>
                        <?php else : ?>
                            <option value="<?php echo $perfil->id; ?>"><?php echo $perfil->descricao; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="imagem">Escolher Imagem de Perfil</label>
                <input type="file" class="form-control" name="imagem" id="imagem"> <br>
                <?php if (isset($usuario->id)) : ?>
                    <img src="<?php echo $usuario->imagem; ?>" class="perfil">
                <?php else : ?>
                    <i class="fas fa-user" style="font-size:40px"></i>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <!--end row-->

    <button type="submit" class="btn btn-success btn-sm button-salvar-usuario" style="float:right"
    onclick="return salvarUsuario()">
        <i class="fas fa-save"></i> Salvar
    </button>
</form>


<script>
    // Anula duplo click em salvar
    anulaDuploClick($('form'));

    function salvarUsuario() {
        if ($("#nome").val() == "") {
            modalValidacao('Validação', 'Campo (Nome) deve ser preenchido!');
            return false;

        } else if ($("#email").val() == "") {
            modalValidacao('Validação', 'Campo (E-mail) deve ser preenchido!');
            return false;
        }
        // Apenas pede para informar a senha, caso não seja uma edição
        <?php if ( ! isset($usuario->id)):?>
            else if ($("#password").val() == "") {
                modalValidacao('Validação', 'Campo (Senha) deve ser preenchido!');
                return false;

            }
        <?php endif;?>
        else if ($("#id_sexo").val() == "selecione") {
            modalValidacao('Validação', 'Campo (Sexo) deve ser preenchido!');
            return false;

        } else if ($("#id_perfil").val() == "selecione") {
            modalValidacao('Validação', 'Campo (Perfil) deve ser preenchido!');
            return false;
        }

        return true;
    }

    function verificaSeEmailExiste(email, id) {
        var rota = getDomain() + "/usuario/verificaSeEmailExiste";
        if (id) {
            rota += '/' + in64(email.value) + '/' + id;
        } else {
            rota += '/' + in64(email.value);
        }

        $.get(rota, function (data, status) {
            var retorno = JSON.parse(data);

            if (retorno.status == true) {
                modalValidacao('Validação', 'Este Email já existe! Por favor, informe outro!');
                $('.button-salvar-usuario').attr('disabled', 'disabled');
                $('.label-email').html('<small style="color:#cc0000!important">Este Email já existe!</small>');
            } else {
                $('.button-salvar-usuario').attr('disabled', false);
                $('.label-email').html('');
            }
        });
    }
</script>
