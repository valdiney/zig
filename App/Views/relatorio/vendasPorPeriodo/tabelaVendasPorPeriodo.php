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
                <span class="badge" style="background:#98c0d5;padding:5px">
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
            <th>#</th>
            <!--<th>Preço</th>-->
            <th>Qtd</th>
            <th>Total</th>
            <th>Venda</th>
            <th>Data</th>
            <th style="text-align:right">Ação</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vendas as $venda): ?>
            <tr>
                <td>
                    <?php if (!is_null($venda->imagem) || $venda->imagem != ''): ?>
                        <img class="imagem-perfil" src="<?php echo BASEURL . '/' . $venda->imagem; ?>"
                             alt="Imagem do perfil"
                             title="<?php echo $venda->nomeUsuario; ?>">
                    <?php else: ?>
                        <i class="fas fa-user" style="font-size:30px"></i>
                    <?php endif; ?>
                </td>

                <?php //if ($venda->preco != 0):?>
                <!--<td>R$ <?php //echo number_format($venda->preco, 2,',','.');?></td>-->
                <?php //else:?>
                <!--<td><small>Não consta produto</small></td>-->
                <?php //endif;?>

                <?php if (!is_null($venda->quantidade)): ?>
                    <td><?php echo $venda->quantidade; ?></td>
                <?php else: ?>
                    <td><small>Não consta</small></td>
                <?php endif; ?>

                <td>R$ <?php echo number_format($venda->valor, 2, ',', '.'); ?></td>
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
                            onclick="modalAtivarEdesativarVenda('<?php echo $venda->idVenda; ?>')">
                                <i class="fas fa-window-close"></i> Excluir esta Venda
                            </button>

                            <!--<a class="dropdown-item" href="#">
                                <i class="fas fa-trash-alt" style="color:#cc6666"></i> Excluir
                            </a>-->

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
    'id' => 'modalDesativarVenda',
    'width' => 'modal-sm',
    'title' => '<i class="fas fa-cart-arrow-down"></i>'
]); ?>
<div id="modalConteudo">
    <p id="nomeCliente">Tem certeza que deseja Excluir esta venda?</p>

    <center>
        <set-modal-button class="set-modal-button"></set-modal-button>
        <button class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="fas fa-window-close"></i> Não
        </button>
    </center>
</div>
<?php Modal::stop(); ?>

<script>
function modalAtivarEdesativarVenda(id) {
    $("set-modal-button").html('<button class="btn btn-sm btn-success" id="buttonDesativarVenda" data-id-venda="'+id+'" onclick="desativarVenda(this)"><i class="far fa-check-circle"></i> Sim</button>');
    $("#modalDesativarVenda").modal({backdrop: 'static'});
}

function desativarVenda(elemento) {
        modalValidacao('Validação', 'Excluindo venda...');
        id = elemento.dataset.idVenda;

        var rota = getDomain() + "/desativarVenda/" + id;
        $.get(rota, function (data, status) {
            var dados = JSON.parse(data);
            if (dados.status == true) {
                location.reload();
                //$("#modalDesativarCliente .close").click();
            }
        });
    }
</script>
