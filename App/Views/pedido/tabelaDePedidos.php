<style>
    #id_situacao_pedido {
        padding: 0px !important;
        background: #faf8f3;
        border: 1px solid #dee2e6;
    }

    @media only screen and (max-width: 600px) {
        th {
            font-size: 10px !important;
        }

        #id_situacao_pedido {
            width: 50px !important;
        }
</style>
<?php $rota = BASEURL . '/pedido/modalFormulario'; ?>
<?php if (count($pedidos) > 0): ?>
    <table id="example" class="table tabela-ajustada table-striped" style="width:100%">
        <thead>
        <tr>
            <th class="hidden-when-mobile">Nº</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Situação</th>
            <th class="hidden-when-mobile">Entrega</th>
            <th class="hidden-when-mobile">Forma de pagamento</th>
            <th class="hidden-when-mobile">Data de compensação</th>
            <th style="text-align:right;padding-right:0">
                <button onclick="modalFormularioPedido('<?php echo $rota; ?>', null);"
                        class="btn btn-sm btn-success" title="Novo Pedido">
                    <i class="fas fa-plus"></i>
                </button>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td class="hidden-when-mobile"><?php echo $pedido->idPedido; ?></td>
                <td><?php echo $pedido->nomeCliente; ?></td>
                <td>R$ <?php echo real($pedido->totalGeral); ?></td>
                <td>
                    <select name="id_situacao_pedido" id="id_situacao_pedido"
                            onchange="alterarSituacaoPedido(<?php echo $pedido->idPedido; ?>, $(this).val())">
                        <?php foreach ($situacoesPedidos as $situacaoPedido): ?>
                            <?php if ($situacaoPedido->id == $pedido->id_situacao_pedido): ?>
                                <option value="<?php echo $situacaoPedido->id; ?>" selected="selected">
                                    <?php echo $situacaoPedido->legenda; ?>
                                </option>
                            <?php else: ?>
                                <option value="<?php echo $situacaoPedido->id; ?>">
                                    <?php echo $situacaoPedido->legenda; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td class="hidden-when-mobile"><?php
                    echo ($pedido->previsaoEntrega == 'Não informado') ? '<small>' . $pedido->previsaoEntrega . '</small>' : $pedido->previsaoEntrega; ?>
                </td>
                <td class="hidden-when-mobile"><?php
                    echo $pedido->forma_pagamento; ?>
                </td>
                <td class="hidden-when-mobile"><?php
                    echo $pedido->data_compensacao; ?>
                </td>
                <td style="text-align:right">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cogs"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start"
                             style="position: absolute; transform: translate3d(0px, 23px, 0px); top: 0px; left: 0px; will-change: transform;">

                            <button class="dropdown-item" href="#"
                                    onclick="modalFormularioPedido('<?php echo $rota; ?>', <?php echo $pedido->idPedido; ?>)">
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
    <br><br><br>
    <center>
        <i class="fas fa-sad-tear" style="font-size:40px;opacity:0.70"></i>
        <br><br>
        <h6 style="opacity:0.70">Pedidos não encontrados!</h6>
        <button
            onclick="modalFormularioPedido('<?php echo $rota; ?>', null);"
            class="btn btn-sm btn-success" title="Cadastrar Pedido!">
            <i class="fas fa-plus"></i>
            Deseja cadastrar algum?
        </button>
    </center>
<?php endif; ?>
