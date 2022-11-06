<?php
$checkedTipoSaida = false;
$checkedTipoEntrada = false;

if (isset($fluxoCaixa->id)) {
    if ($fluxoCaixa->tipo_movimento == 1) {
        $checkedTipoEntrada = "checked";
    } else if ($fluxoCaixa->tipo_movimento == 0) {
        $checkedTipoSaida = "checked";
    }
}
?>
<form method="post" action="<?php echo isset($fluxoCaixa->id) ? BASEURL . '/fluxoDeCaixa/update' : BASEURL . '/fluxoDeCaixa/save'; ?>">
    <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

    <?php if (isset($fluxoCaixa->id)):?>
        <input type="hidden" name="id" value="<?php echo $fluxoCaixa->id; ?>"/>
    <?php endif;?>

    <div class="row">
        <div class="col-md-4">
            <label for="text">Tipo Movimentação</label> <br>
            <input class="w3-radio" type="radio" name="tipo_movimento" id="tipo_entrada" value="1"
            <?php echo $checkedTipoEntrada;?>>
            <label>+Entrada</label>

            <input class="w3-radio" type="radio" name="tipo_movimento" id="tipo_saida" value="0"
            <?php echo $checkedTipoSaida;?>>
            <label>-Saída</label>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="descricao">Descrição *</label>
                <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Digite a descrição..."
                    value="<?php echo isset($fluxoCaixa->id) ? $fluxoCaixa->descricao : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="data">Data vencimento *</label>
                <input type="date" class="form-control" name="data" id="data"
                    value="<?php echo isset($fluxoCaixa->id) ? date('Y-m-d', strtotime($fluxoCaixa->data)) : date('Y-m-d'); ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="text">Categoria</label>
                <select class="form-control js-example-basic-single " name="id_categoria" id="id_categoria">
                    <option value="3">Selecione</option>
                </select>
                <a href="#" title="Criar nova Categoria" onclick="return modalCategoria()"><small><i class="fas fa-plus" style="color:#0075ff"></i> Nova categoria</small></a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="valor">R$ Valor *</label>
                <input type="text" class="form-control campo-moeda" name="valor" id="valor" placeholder="R$ 0,00"
                    value="<?php echo isset($fluxoCaixa->id) ? real($fluxoCaixa->valor) : '' ?>">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success btn-sm button-salvar-empresa"
        style="float:right" onclick="return salvarMovimentacaoFluxoDeCaixa()">
        <i class="fas fa-save"></i> Salvar
    </button>
</form>

<script>
    // Anula duplo click em salvar
    anulaDuploClick($('form'));
    function salvarMovimentacaoFluxoDeCaixa() {
        if ( ! $("#tipo_entrada").prop("checked") && ! $("#tipo_saida").prop("checked")) {
            modalValidacao('Validação', 'Campo (Tipo Movimentação) deve ser preenchido! <br> <small>Informe se é uma entrada ou saída</small>');
            return false;

        } else if ($("#descricao").val() == '') {
            modalValidacao('Validação', 'Campo (Descrição) deve ser preenchido!');
            return false;

        } else if ($("#valor").val() == '') {
            modalValidacao('Validação', 'Campo (Valor) deve ser preenchido!');
            return false;
        }
        return true;
    }

    $(function () {
        jQuery('.campo-moeda')
            .maskMoney({
                prefix: 'R$ ',
                allowNegative: false,
                thousands: '.', decimal: ',',
                affixesStay: false
            });
    });

    function modalCategoria() {
        alert('oi');
        return false;
    }
</script>
