<style type="text/css">
    small {

    #small-mensagem {
        font-size: 8px !important;
        opacity: 0.60;
    }

    }
</style>

<form method="post"
      action="<?php echo isset($clienteEndereco->id) ? BASEURL . '/clienteEndereco/update' : BASEURL . '/clienteEndereco/save'; ?>"
      enctype='multipart/form-data'>
    <div class="row">

        <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

        <?php if (isset($clienteEndereco->id)): ?>
            <input type="hidden" name="id" value="<?php echo $clienteEndereco->id; ?>">
        <?php endif; ?>

        <input type="hidden" name="id_cliente" value="<?php echo $idCliente; ?>">

        <div class="col-md-4">
            <div class="form-group">
                <label for="cep">CEP*</label>
                <input type="text" class="form-control" name="cep" id="cep" placeholder="Digite o CEP!"
                       value="<?php echo isset($clienteEndereco->id) ? $clienteEndereco->cep : '' ?>"
                       onchange="return buscarEnderecoViaCep(this)">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="endereco">Endereço *</label>
                <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Digite o endereço!"
                       value="<?php echo isset($clienteEndereco->id) ? $clienteEndereco->endereco : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="bairro">Bairro *</label>
                <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Digite o bairro!"
                       value="<?php echo isset($clienteEndereco->id) ? $clienteEndereco->bairro : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="numero">Número *</label>
                <input type="text" class="form-control" name="numero" id="numero" placeholder="Exemplo: 14-E"
                       value="<?php echo isset($clienteEndereco->id) ? $clienteEndereco->numero : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="estado">Estado</label>
                <input type="text" class="form-control" name="estado" id="estado" placeholder="Estado!"
                       value="<?php echo isset($clienteEndereco->id) ? $clienteEndereco->estado : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade!"
                       value="<?php echo isset($clienteEndereco->id) ? $clienteEndereco->cidade : '' ?>">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="complemento">Complemento</label>
                <textarea class="form-control" name="complemento" id="complemento"
                          placeholder="Complemento..."
                ><?php echo isset($clienteEndereco->id) ? $clienteEndereco->complemento : '' ?></textarea>
            </div>
        </div>

    </div><!--end row-->

    <button type="submit" class="btn btn-success btn-sm" style="float:right"
            onclick="return salvarEndereco()">
        <i class="fas fa-save"></i> Salvar
    </button>

</form>

<script src="<?php echo BASEURL; ?>/public/js/maskedInput.js"></script>
<script>
    // Anula duplo click em salvar
    anulaDuploClick($('form'));

    <?php if (isset($cliente->id)):?>
    <?php if ($cliente->id_cliente_tipo == 1):?>

    $("#cnpj").attr('disabled', 'disabled');
    $("#id_cliente_segmento").attr('disabled', 'disabled');
    $("#cpf").attr('disabled', false);

    <?php elseif ($cliente->id_cliente_tipo == 2):?>

    $("#cnpj").attr('disabled', false);
    $("#id_cliente_segmento").attr('disabled', false);
    $("#cpf").attr('disabled', 'disabled');

    <?php endif;?>
    <?php endif;?>


    function salvarEndereco() {
        if ($('#cep').val() == '') {
            modalValidacao('Validação', 'Campo (CEP) deve ser preenchido!');
            return false;

        } else if ($('#endereco').val() == '') {
            modalValidacao('Validação', 'Campo (Endereço) deve ser preenchido!');
            return false;

        } else if ($('#bairro').val() == '') {
            modalValidacao('Validação', 'Campo (Bairro) deve ser preenchido!');
            return false;

        } else if ($('#numero').val() == '') {
            modalValidacao('Validação', 'Campo (Número) deve ser preenchido!');
            return false;
        }

        return true;
    }

    jQuery(function ($) {
        jQuery("#cep").mask("99.999-999");
    });

    function buscarEnderecoViaCep(cep) {
        modalValidacao('Validação', 'Buscando CEP...');

        var rota = getDomain() + "/clienteEndereco/buscarEnderecoViaCep/" + in64(cep.value);
        $.get(rota, function (data, status) {
            var dados = JSON.parse(data);

            if (dados.status == true) {
                modalValidacaoClose();
                $("#endereco").val(dados.conteudo.logradouro);
                $("#bairro").val(dados.conteudo.bairro);
                $("#cidade").val(dados.conteudo.localidade);
                $("#estado").val(dados.conteudo.uf);
            } else {
                modalValidacao('Validação', dados.mensagem + '<br><small id="small-mensagem">Preencha o endereço manualmente!</small>');
            }
        });
    }
</script>
