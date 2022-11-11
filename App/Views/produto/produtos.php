<?php if (count($produtos) > 0):?>
    <table class="table tabela-ajustada table-striped" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>R$ Preço</th>
            <th>Em vendas</th>
            <th>Quantidade</th>
            <th style="text-align:right;padding-right:0">
                <?php $rota = BASEURL . '/produto/modalFormulario'; ?>
                <button onclick="modalFormularioProdutos('<?php echo $rota; ?>', false);"
                        class="btn btn-sm btn-success" title="Novo Produto!">
                    <i class="fas fa-plus"></i>
                </button>
            </th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td>
                    <?php if (!is_null($produto->imagem) && $produto->imagem != ''): ?>
                        <center>
                            <?php $imagem = BASEURL . '/' . $produto->imagem; ?>
                            <img src="<?php echo $imagem; ?>" width="40"
                                class="imagem-produto" title="Visualizar Imagem!"
                                onclick="modalImagemDoProduto('<?php echo $imagem;?>', '<?php echo $produto->nome;?>')">
                        </center>
                    <?php else: ?>
                        <center><i class="fas fa-box-open" style="font-size:25px"></i></center>
                    <?php endif; ?>
                </td>

                <td><?php echo $produto->nome; ?></td>
                <td><?php echo real($produto->preco); ?></td>
                <?php if ($produto->mostrar_em_vendas == true):?>
                    <td><small>Sim</small></td>
                <?php else:?>
                    <td class="with_deleted_at"><Small>Não</Small></td>
                <?php endif;?>

                <td>
                    <?php if ($produto->ativar_quantidade):?>
                        <?php echo $produto->quantidade;?>
                        <?php echo ($produto->quantidade > 1) ? '<small>Unidades</small>' : '<small>Unidade</small>';?>
                    <?php else:?>
                        <small>Desabilitado</small>
                    <?php endif;?>
                </td>

                <td style="text-align:right">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cogs"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                            <button class="dropdown-item" href="#"
                                    onclick="modalFormularioProdutos('<?php echo $rota; ?>', '<?php echo $produto->id; ?>')">
                                <i class="fas fa-edit"></i> Editar
                            </button>

                            <a class="dropdown-item" href="#" onclick="return excluirProduto('<?php echo $produto->id;?>')">
                                <i class="fas fa-trash-alt" style="color:#cc6666"></i> Excluir
                            </a>

                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

        <tfoot></tfoot>
    </table>
<?php else:?>
    <h6 style="display:block;margin:0 auto;margin-top:50px;text-align:center">
        <center><i class="fas fa-sad-tear" style="font-size:40px;opacity:0.70;text-align:center"></i></center>
        <br>
        Nenhum Produto encontrado!
    </h6>

    <center>
        <?php if (!$nome && !isset($codigo)):?>
            Poxa, ainda não há nenhum Produto cadastrado! <br>
        <?php endif; ?>

        <?php $rota = BASEURL . '/produto/modalFormulario'; ?>
        <button
            onclick="modalFormularioProdutos('<?php echo $rota; ?>', false);"
            class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i>
            Cadastrar Produto
        </button>
    </center>
<?php endif;?>
