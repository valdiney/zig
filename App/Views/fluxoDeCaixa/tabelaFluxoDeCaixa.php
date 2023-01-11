<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal; ?>

<style>
    .fromPDV td{
        background:#e4fbe9!important;
        margin-top:5px!important;
        border:1px dotted #41da67;
    }
    #label_incluir_pdv {
        border:1px solid #f3f2ee;
        background:#f3f2ee;
        border-radius:5px;
        padding:2px;
        padding-left:4px;
        padding-right:4px;
        margin-left:10px;
    }
</style>

<div class="card-body">

    <small style="opacity:0.70">
        Fluxo de Caixa:
        <b><?php echo mesesPorExtensoEnumeroDoMes(date('m'));?> de <?php echo date('Y');?></b>
    </small>

    <label for="checkbox_incluir_pdv" id="label_incluir_pdv">
        Ocultar PDV <input type="checkbox" id="checkbox_incluir_pdv" onclick="return incluirPDV($(this))"
        <?php echo ($retirarPDV == 1) ? 'checked' : false;?>>
    </label>
    <hr>

    <table class="table tabela-ajustada table-stripeds">
        <thead>
            <tr>
                <th style="text-align:center">Entradas</th>
                <th style="text-align:center">Saídas</th>
                <th style="text-align:center">Saldo</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="background:#bad7c2;text-align:center">R$ <?php echo real($fluxo->entradas);?></td>
                <td style="background:#f6d6d6;text-align:center">R$ <?php echo real($fluxo->saidas);?></td>
                <td style="background:#c4d9e4;text-align:center">R$ <?php echo real($fluxo->restante);?></td>
            </tr>
        </tbody>
    </table>

    <table class="table tabela-ajustada table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Lançamento</th>
                <th>Vencimento</th>
                <th style="text-align:right;padding-right:0">
                    <button onclick="modalRegistrarMovimentacao('<?php echo BASEURL?>/fluxoDeCaixa/modalRegistrarMovimentacao', false);" class="btn btn-sm btn-success" title="Registrar Movimentações!">
                        <i class="fas fa-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($fluxoDetalhadoPorMes as $fluxoCaixa):?>
                <tr <?php echo isset($fluxoCaixa->fromPDV) ? 'class="fromPDV"' : false;?>>
                    <td><?php echo ($fluxoCaixa->tipo_movimento == 1) ? '<i class="fas fa-arrow-right" style="color:#41da67" title="Entrada"></i>' : '<i class="fas fa-arrow-left" style="color:#e96969" title="Saída"></i>';?></td>
                    <td><?php echo $fluxoCaixa->descricao;?></td>
                    <td>R$ <?php echo real($fluxoCaixa->valor);?></td>
                    <td><?php echo date('d/m/Y', strtotime($fluxoCaixa->created_at));?></td>
                    <td><?php echo date('d/m/Y', strtotime($fluxoCaixa->data));?></td>

                    <td style="text-align:right;padding-right:0">
                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?php echo (isset($fluxoCaixa->fromPDV) ? 'disabled' : false)?>>
                            <i class="fas fa-cogs"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <button class="dropdown-item" href="#"
                            onclick="modalRegistrarMovimentacao('<?php echo BASEURL?>/fluxoDeCaixa/modalRegistrarMovimentacao', '<?php echo $fluxoCaixa->id;?>')">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <?php if (
        $fluxo->entradas == 0
        && $fluxo->saidas == 0
        && $fluxo->restante == 0
        && count($fluxoDetalhadoPorMes) == 0
    ):?>

    <div class="text-center">
        <i class="fas fa-sad-tear" style="font-size:40px;opacity:0.70"></i>
        <br><br>
        <h6 style="opacity:0.70">Nenhum dado encontrado!</h6>
    </div>

    <?php endif;?>
</div>

<?php Modal::start([
    'id' => 'modalRegistrarMovimentacao',
    'width' => 'modal-lg',
    'title' => 'Registrar Movimentações'
]); ?>

<div id="formulario"></div>

<?php Modal::stop(); ?>

<script>
    function modalRegistrarMovimentacao(rota, id) {
        var url = "";

        if (id) {
            url = rota + "/" + id;
        } else {
            url = rota;
        }

        $("#formulario").html("<center><h3>Carregando...</h3></center>");
        $("#modalRegistrarMovimentacao").modal({backdrop: 'static'});
        $("#formulario").load(url);
    }
</script>
