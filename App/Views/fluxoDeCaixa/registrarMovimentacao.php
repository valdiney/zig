<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal; ?>

<style>

</style>
<div class="row">
    <div class="card col-lg-12" style="padding-bottom:0!">
        <?php require_once('menu.php');?>
    </div>
</div>

<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-money-bill"></i> Registrar Movimentos</h5>
        </div>

        <form method="post" action="<?php echo BASEURL;?>/fluxoDeCaixa/save">
            <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

            <div class="row">
                <div class="col-md-4">
                    <label for="text">Tipo Movimentação</label> <br>
                    <input class="w3-radio" type="radio" name="tipo_movimento" id="tipo_entrada" class="tipo_movimento" value="1">
                    <label>+Entrada</label>

                    <input class="w3-radio" type="radio" name="tipo_movimento" id="tipo_saida" class="tipo_movimento" value="0">
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
                            <option value="1">Aluguel</option>
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

        <br>
    </div>
</div>

<script>
    anulaDuploClick($('form'));
    function salvarMovimentacaoFluxoDeCaixa() {
        alert('te3ste');
        if ($("#tipo_entrada").prop("checked", false) && $("#tipo_saida").prop("checked", false)) {
            modalValidacao('Validação', 'Campo (Tipo Movimentação) deve ser preenchido!');
            return false;
        }

        return false;

        //return true;
    }
</script>
