<div class="row div-inter-produtos">
    <?php if (count($produtos) > 0):?>
        <?php foreach ($produtos as $key => $produto): ?>
            <div class="col-lg-2 card-produtos">
                <?php if (!is_null($produto->imagem) && $produto->imagem != ''): ?>
                    <img src="<?php echo BASEURL . '/' . $produto->imagem; ?>" title="Adicionar!"
                        onclick="colocarProdutosNaMesa('<?php echo $produto->id; ?>', this)">
                        <?php else: ?>
                    <i class="fas fa-box-open icone-produtos" style="font-size:50px"
                    onclick="colocarProdutosNaMesa('<?php echo $produto->id; ?>', this)" title="Adicionar!"></i>
                <?php endif; ?>

                <center>
                    <span class="produto-titulo"><?php echo mb_strtoupper($produto->nome); ?></span>
                </center>
                <center><span class="produto-valor">R$ <?php echo real($produto->preco); ?></span></center>
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
