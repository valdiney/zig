<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal; ?>

<style>
    .span-badge {
        background:#eceaea;
        padding:5px;
        border-radius:5px;
        margin-right:5px;
        color:gray;
        border:1px solid #e0dcdc;
    }

    @media print {
        /* esconder tudo */
        body * {
            visibility: hidden;
        }
        /* exibir somente o que tem na div para imprimir */
        #imprimir, #imprimir * {
            visibility: visible;
        }
        #imprimir {
            position: fixed;
            left: 0;
            top: 0;
            border:1px solid #dee2e6!important;
            padding:10px;
        }

        .hidden-when-print {
            visibility: hidden!important;
        }

        table tr td, th {
            border:1px solid #dee2e6!important;
            text-align:center!important;
        }

        table {
            width:600px!important;
            margin:left!important;
            display:block;
        }
    }
</style>

<div id="imprimir">
    <div style="margin-bottom:20px descricao-venda">
        <span class="span-badge">
            Total: R$ <?php echo real($detalhesDePagamentoItensDaVenda->total);?>
        </span>
        <?php if ($detalhesDePagamentoItensDaVenda->id_meio_pagamento == 1):?>
            <span class="span-badge">
                Recebido: R$ <?php echo real($detalhesDePagamentoItensDaVenda->valor_recebido);?>
            </span>
            <span class="span-badge">
                Troco: R$ <?php echo real($detalhesDePagamentoItensDaVenda->troco);?>
            </span>
        <?php endif;?>

        <a style="margin-top:6px" href="<?php echo BASEURL; ?>/relatorio/gerarPdfDeUmaVenda/<?php echo in64($detalhesDePagamentoItensDaVenda->codigo_venda)?>"
        target="_blank"  id="imprimir-nota" style="opacity:0.80"
        class="hidden-when-print btn btn-sm btn-light" title="Gerar PDF desta venda.">
            <i class="fas fa-cloud-download-alt"></i> PDF
        </a>
    </div>

    <table class="table tabela-ajustada table-striped">
            <thead>
            <tr>
                <th class="hidden-when-mobile hidden-when-print">#</th>
                <th class="hidden-when-mobile">Produto</th>
                <th title="Quantidade do Produto Vendido">Qtd</th>
                <th>Total</th>
                <th class="hidden-when-mobile" title="Tipo de Pagamento">Pag</th>
                <th>Data</th>
                <th style="text-align:right" class="hidden-when-print">Ação</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($vendas as $venda): ?>
                <tr>
                    <td class="hidden-when-mobile hidden-when-print">
                        <?php if (!is_null($venda->imagem) || $venda->imagem != ''): ?>
                            <img class="imagem-perfil hidden-when-print" src="<?php echo BASEURL . '/' . $venda->imagem; ?>"
                                alt="Imagem do perfil"
                                title="<?php echo $venda->nomeUsuario; ?>">
                        <?php else: ?>
                            <i class="fas fa-user hidden-when-print" style="font-size:30px"></i>
                        <?php endif; ?>
                    </td>

                    <td class="hidden-when-mobile">
                        <?php if (!is_null($venda->produtoImagem) || $venda->produtoImagem != ''): ?>
                            <img class="imagem-perfil" style="border:1px solid silver" src="<?php echo BASEURL . '/' . $venda->produtoImagem; ?>"
                                alt="Imagem do perfil"
                                title="<?php echo $venda->produtoNome . ' | R$:' . real($venda->preco); ?>">
                        <?php elseif (!is_null($venda->quantidade)): ?>
                            <!--<i class="fas fa-box-open" style="font-size:20px"></i>-->
                            <i title="<?php echo ucfirst($venda->produtoNome);?>">
                                <?php echo stringAbreviation(ucfirst($venda->produtoNome), 15, '...');?>
                            </i>
                        <?php else: ?>
                            <small>Não consta</small>
                        <?php endif; ?>
                    </td>

                    <?php if (!is_null($venda->quantidade)): ?>
                        <td><?php echo $venda->quantidade; ?></td>
                    <?php else: ?>
                        <td><small>Não consta</small></td>
                    <?php endif; ?>

                    <td><b style="opacity:0.60">R$</b> <?php echo real($venda->valor); ?></td>
                    <td class="hidden-when-mobile"><?php echo $venda->legenda; ?></td>
                    <td>
                        <?php echo $venda->data; ?>
                        <?php echo $venda->hora; ?>h
                    </td>

                    <td style="text-align:right" class="hidden-when-print">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cogs hidden-when-print"></i>
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
    </div>
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
        <button class="btn btn-sm btn-default" onclick="closeModal('modalDesativarVenda')">
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
</script>
