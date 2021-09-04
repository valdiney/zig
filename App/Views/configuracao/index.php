<style type="text/css">
    .radio-options {
        background: #f4f3ef;
        padding: 5px;
        border-radius: 5px;
    }
</style>
<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-cogs"></i> Configurações</h5>
        </div>

        <table id="example" class="table tabela-ajustada" style="width:100%">
            <thead>
            <tr>
                <th>Descrição</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Módulo de Vendas</td>
                <td>
                    <?php foreach ($tiposPdv as $tipoPdv): ?>
                        <label for="id_<?php echo $tipoPdv->id; ?>" class="radio-options"
                               onclick="alterarConfigPdv('<?php echo $configPdv->idConfigPdv; ?>','<?php echo $tipoPdv->id; ?>')">
                            <input type="radio" name="id_tipo_pdv" id="id_<?php echo $tipoPdv->id; ?>"
                                <?php echo ($tipoPdv->id == $configPdv->id_tipo_pdv) ? 'checked' : '' ?>>
                            <?php echo $tipoPdv->descricao; ?>
                        </label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tfoot></tfoot>
        </table>

        <br>

    </div>
</div>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>
<script>
    function alterarConfigPdv(idConfigPdv, idTipoPdv) {
        var rota = getDomain() + "/configuracao/alterarConfigPdv";
        modalValidacao('Salvando', 'Alterando PDV! <small>Aguarde...</small>');
        $(".close").hide();

        $.post(rota, {
            '_token': '<?php echo TOKEN; ?>',
            'idConfigPdv': idConfigPdv,
            'idTipoPdv': idTipoPdv
        }, function (result) {
            tipoPdv = JSON.parse(result);
            if (tipoPdv.status == true) {
                window.location.href = getDomain() + "/configuracao";
            }
        });
    }
</script>
