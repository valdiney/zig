<style type="text/css">
    .modal-content {
        width: 100%;
        height: 100%;
    }
</style>

<?php if (count($clienteEnderecos) > 0): ?>
    <table class="table tabela-ajustada table-striped" style="width:100%">
        <thead>
        <tr>
            <th>Endereço</th>
            <th>Cidade</th>
            <th style="text-align:right;padding-right:0">
                <?php $rota = BASEURL . '/clienteEndereco/modalFormulario'; ?>
                <button
                    onclick="modalFormularioEndereco('<?php echo $rota; ?>', <?php echo $cliente->id; ?>, null);"
                    class="btn btn-sm btn-success" title="Novo Endereço!">
                    <i class="fas fa-plus"></i>
                </button>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($clienteEnderecos as $endereco): ?>
            <tr>
                <td>
                    <?php echo $endereco->endereco ?> <b>Nª</b> <?php echo $endereco->numero; ?>
                </td>
                <td><?php echo $endereco->cidade; ?></td>

                <td style="text-align:right">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cogs"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                            <?php $rota = BASEURL . '/clienteEndereco/modalFormulario'; ?>
                            <button class="dropdown-item" href="#"
                                    onclick="modalFormularioEndereco('<?php echo $rota; ?>', <?php echo $cliente->id; ?>, <?php echo $endereco->id; ?>);">
                                <i class="fas fa-edit"></i> Editar
                            </button>

                            <!--<a class="dropdown-item" href="#">
                              <i class="fas fa-trash-alt" style="color:#cc6666"></i> Excluir
                            </a>-->
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <tfoot></tfoot>
    </table>

<?php else: ?>
    <center>
        <i class="far fa-grin-beam" style="font-size:50px;opacity:0.60"></i> <br> <br>
        Poxa, ainda não há endereços cadastrados para este Cliente! <br>
        <?php $rota = BASEURL . '/clienteEndereco/modalFormulario'; ?>
        <button
            onclick="modalFormularioEndereco('<?php echo $rota; ?>', <?php echo $cliente->id; ?>, null);"
            class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i>
            Cadastrar Endereço
        </button>
    </center>
<?php endif; ?>

<script src="<?php echo BASEURL; ?>/public/js/maskedInput.js"></script>
<script>
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
