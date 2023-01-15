<style>
    .estoque_esgotado {
        opacity:0.80;
    }
    .estoque_esgotado img {
        filter: grayscale(100%);
    }
</style>
<div class="row div-inter-produtos">
    <?php if (count($produtos) > 0):?>
        <?php foreach ($produtos as $key => $produto): ?>
            <?php
               $seProdutoEsgotado = false;
               if ($produto->ativar_quantidade && $produto->quantidade == 0) {
                $seProdutoEsgotado = 'esgotado';
               }
            ?>
            <div class="col-lg-2 card-produtos <?php echo $seProdutoEsgotado == 'esgotado' ? 'estoque_esgotado' : false;?>">
                <?php if (!is_null($produto->imagem) && $produto->imagem != ''): ?>
                    <img src="<?php echo BASEURL . '/' . $produto->imagem; ?>" title="Adicionar!"
                        onclick="colocarProdutosNaMesa('<?php echo $produto->id; ?>', this, '<?php echo $seProdutoEsgotado;?>')">
                        <?php else: ?>
                    <i class="fas fa-box-open icone-produtos" style="font-size:50px"
                    onclick="colocarProdutosNaMesa('<?php echo $produto->id; ?>', this, '<?php echo $seProdutoEsgotado;?>')" title="Adicionar!"></i>
                <?php endif; ?>

                <center>
                    <span class="produto-titulo"><?php echo mb_strtoupper($produto->nome); ?></span>
                </center>
                <center><span class="produto-valor">R$ <?php echo real($produto->preco); ?></span></center>

                <?php if ($produto->ativar_quantidade):?>
                    <center>
                        <small style="opacity:0.60">
                            <?php if ($produto->quantidade == 0):?>
                                <Estoque style="color:#990000">Esgotado</i>
                            <?php else:?>
                                <?php //echo $produto->quantidade;?>
                                <?php //echo ($produto->quantidade > 1) ? 'unidades em estoque' : 'unidade em estoque';?>
                            <?php endif;?>
                        </small>
                    </center>
                <?php endif;?>
            </div>
        <?php endforeach; ?>
    <?php else:?>
        <h6 style="display:block;margin:0 auto;margin-top:100px">
            <center><i class="fas fa-sad-tear" style="font-size:40px;opacity:0.70;text-align:center"></i></center>
            <br>
            Nenhum Produto encontrado!
        </h6>
    <?php endif;?>
</div><!--div-inter-produtos-->
