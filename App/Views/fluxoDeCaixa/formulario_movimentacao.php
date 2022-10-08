<form method="post" action="<?php echo BASEURL;?>/fluxoDeCaixa/save">
    <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

    <div class="row">
        <div class="col-md-4">
            <label for="text">Tipo Movimentação</label> <br>
            <input class="w3-radio" type="radio" name="tipo_movimento" value="1">
            <label>+Entrada</label>

            <input class="w3-radio" type="radio" name="tipo_movimento" value="0">
            <label>-Saída</label>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Digite a descrição..."
                    value="<?php echo isset($usuario->id) ? $usuario->nome : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" class="form-control" name="data" id="data"
                    value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
                <div class="form-group">
                    <label for="text">Categoria</label>
                    <select class="form-control js-example-basic-single " name="id_categoria" id="id_categoria">
                        <option value="selecione">Selecione</option>
                        <option value="3">Padrao</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="valor">R$ Valor</label>
                    <input type="text" class="form-control campo-moeda" name="valor" id="valor" placeholder="R$ 0,00"
                        value="<?php echo isset($usuario->id) ? $usuario->nome : '' ?>">
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
</script>
