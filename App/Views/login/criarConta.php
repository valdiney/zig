<form method="post"
      action="<?php echo isset($empresa->id) ? BASEURL . '/empresa/update' : BASEURL . '/empresa/save'; ?>"
      enctype='multipart/form-data'>
    <!-- token de segurança -->
    <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>



        <?php if (isset($empresa->id)) : ?>
            <input type="hidden" name="id" value="<?php echo $empresa->id; ?>">
        <?php endif; ?>

        <div class="col-md-12">
            <div class="form-group">
                <label for="nome">Nome da Empresa *</label>
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite aqui..."
                       value="<?php echo isset($empresa->id) ? $empresa->nome : '' ?>">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="email">E-mail * <span class="label-email"></span></label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Digite o e-mail!"
                       value="<?php echo isset($empresa->id) ? $empresa->email : '' ?>"
                       onchange="verificaSeEmailExiste(this, <?php echo isset($empresa->id) ? $empresa->id : false; ?>)">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="id_segmento">Segmento *</label>
                <select class="form-control" name="id_segmento" id="id_segmento">
                    <option value="selecione">Selecione</option>
                    <?php foreach ($segmentos as $segmento) : ?>
                        <?php if (isset($empresa->id) && $empresa->id_segmento == $segmento->id) : ?>
                            <option value="<?php echo $empresa->id_segmento; ?>"
                                    selected="selected"><?php echo $segmento->descricao; ?>
                            </option>
                        <?php else : ?>
                            <option value="<?php echo $segmento->id; ?>">
                                <?php echo $segmento->descricao; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>


    <div class="col-md-12">
        <button class="btn btn-lg btn-primary btn-block text-uppercase" onclick="return salvarEmpresas()">Entrar</button>
    </div>

</form>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>
<script src="<?php echo BASEURL; ?>/public/js/maskedInput.js"></script>
<script src="<?php echo BASEURL; ?>/public/js/helpers.js"></script>

<script>
    // Anula duplo click em salvar
    anulaDuploClick($('form'));


    function salvarEmpresas() {
        if ($('#nome').val() == '') {
            modalValidacao('Validação', 'Campo (Nome) deve ser preenchido!');
            return false;

        } else if ($('#email').val() == '') {
            modalValidacao('Validação', 'Campo (Email) deve ser preenchido!');
            return false;

        } else if (!emailValido($('#email').val())) {
            modalValidacao('Validação', 'Digite um Email valido!');
            return false;

        } else if ($('#id_cliente_segmento').val() == 'selecione') {
            modalValidacao('Validação', 'Em qual segmento esta empresa atua?');
            return false;
        }

        return true;
    }

    function verificaSeEmailExiste(email, id) {
        var rota = getDomain() + "/empresa/verificaSeEmailExiste";
        if (id) {
            rota += '/' + in64(email.value) + '/' + id;
        } else {
            rota += '/' + in64(email.value);
        }

        $.get(rota, function (data, status) {
            var retorno = JSON.parse(data);

            if (retorno.status == true) {
                modalValidacao('Validação', 'Este Email já existe! Por favor, informe outro!');
                $('.button-salvar-empresa').attr('disabled', 'disabled');
                $('.label-email').html('<small style="color:#cc0000!important">Este Email já existe!</small>');
            } else {
                $('.button-salvar-empresa').attr('disabled', false);
                $('.label-email').html('');
            }
        });
    }

    //jQuery('#id_segmento').select2();
</script>
