<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal; ?>
<?php if (count($vendas) > 0): ?>
    <br>

    <div style="float:right;">

        <h6 style="text-align:right;">
            Total:
            <span style="color:#666666!important">R$ <?php echo real($totalDasVendas); ?></span>
        </h6>

        <?php foreach ($meiosDePagamento as $tipo): ?>
            <?php if ($tipo->idMeioPagamento == 1): ?>
                <span class="badge" style="background:#83e6cd;padding:5px">
				      <?php echo $tipo->legenda; ?> R$ <?php echo real($tipo->totalVendas); ?>
				 </span>
            <?php elseif ($tipo->idMeioPagamento == 2): ?>
                <span class="badge" style="background:#9be6e6;padding:5px">
				      <?php echo $tipo->legenda; ?> R$ <?php echo real($tipo->totalVendas); ?>
				 </span>
            <?php elseif ($tipo->idMeioPagamento == 3): ?>
                <span class="badge" style="background:#dbb4dc;padding:5px">
				      <?php echo $tipo->legenda; ?> R$ <?php echo real($tipo->totalVendas); ?>
				 </span>
            <?php elseif ($tipo->idMeioPagamento == 4): ?>
                <span class="badge" style="background:#cfa18c;padding:5px">
				      <?php echo $tipo->legenda; ?> R$ <?php echo real($tipo->totalVendas); ?>
				 </span>
            <?php elseif ($tipo->idMeioPagamento == 5): ?>
                <span class="badge" style="background:#73b1a2;padding:5px">
				      <?php echo $tipo->legenda; ?> R$ <?php echo real($tipo->totalVendas); ?>
				 </span>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div style="clear:both;"></div>
    <hr>

    <table class="table tabela-ajustada table-striped">
        <thead>
        <tr>
            <th class="hidden-when-mobile">#</th>
            <th>Total</th>
            <th title="Tipo de Pagamento">Pag</th>
            <th>Data</th>
            <th style="text-align:right">Ação</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vendas as $venda): ?>
            <tr>
                <td class="hidden-when-mobile">
                    <?php if (!is_null($venda->imagem) || $venda->imagem != ''): ?>
                        <img class="imagem-perfil" src="<?php echo BASEURL . '/' . $venda->imagem; ?>"
                             alt="Imagem do perfil"
                             title="<?php echo $venda->nomeUsuario; ?>">
                    <?php else: ?>
                        <i class="fas fa-user" style="font-size:30px"></i>
                    <?php endif; ?>
                </td>

                <td><b style="opacity:0.60">R$</b> <?php echo real($venda->total); ?></td>
                <td><?php echo $venda->legenda; ?></td>
                <td>
                    <?php echo $venda->data; ?>
                    <?php echo $venda->hora; ?>h
                </td>

                <td style="text-align:right">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cogs"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                            <button class="dropdown-item" href="#"
                            onclick="modalAItensDaVenda('<?php echo $venda->codigoVenda; ?>')">
                                <i class="fas fa-aye"></i> Detalhes
                            </button>
                        </div>
                    </div>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <br><br><br>
    <div class="text-center">
        <i class="fas fa-sad-tear" style="font-size:40px;opacity:0.70"></i>
        <br><br>
        <h6 style="opacity:0.70">Vendas não encontradas!</h6>
    </div>
<?php endif; ?>

<!--Modal Desativar e ativar Clientes-->
<?php Modal::start([
    'id' => 'modalItensDaVenda',
    'width' => 'modal-lg',
    'title' => '<i class="fas fa-cart-arrow-down"></i> Itens da venda'
]); ?>
    <div id="modalConteudo" class="div-itens-da-venda"></div>
<?php Modal::stop(); ?>

<script>
function modalAItensDaVenda(codigoVenda) {
    let url = "<?php echo BASEURL; ?>/relatorio/itensDaVenda/"+in64(codigoVenda);
    $(".div-itens-da-venda").load(url);
    $("#modalItensDaVenda").modal({backdrop: 'static'});
}

function desativarVenda(elemento) {
        modalValidacao('Validação', 'Excluindo venda...');
        id = elemento.dataset.idVenda;

        var rota = getDomain() + "/desativarVenda/" + id;
        $.get(rota, function (data, status) {
            var dados = JSON.parse(data);
            if (dados.status == true) {
                location.reload();
            }
        });
    }
</script>
