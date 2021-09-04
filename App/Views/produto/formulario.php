<link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/public/css/jquery-te-1.4.0.css">

<?php if (isset($produto->id)): ?>
    <div class="row">
        <div class="col-md-12" style="opacity:0.80;background:#fffcf5">
           <img src="<?php gerarCodigoDeBarrasEmPng($produto->codigo);?>" width="100"> <br>
           <span style="font-size:12px;color:black;margin-left:25px"><?php echo isset($produto->id) ? $produto->codigo : false;?></span>
        </div>
    </div>
    <hr>
<?php endif; ?>

<form method="post"
      action="<?php echo isset($produto->id) ? BASEURL . '/produto/update' : BASEURL . '/produto/save'; ?>"
      enctype='multipart/form-data'>
    <div class="row">

        <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

        <?php if (isset($produto->id)): ?>
            <input type="hidden" name="id" value="<?php echo $produto->id; ?>">
        <?php endif; ?>

        <input type="hidden" name="id_empresa" value="1">

        <div class="col-md-6">
            <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" class="form-control nome" name="nome" id="nome"
                       placeholder="Digite o nome do produto!"
                       value="<?php echo isset($produto->id) ? $produto->nome : '' ?>">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="preco">R$ Preço *</label>
                <input type="text" class="form-control campo-moeda" name="preco" id="preco" placeholder="00,00"
                       value="<?php echo isset($produto->preco) ? real($produto->preco) : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="imagem">Escolher Imagem do Produto</label>
                <input type="file" class="form-control" name="imagem" id="imagem"> <br>
                <?php if (isset($produto->id) && ! is_null($produto->imagem)): ?>
                    <img src="<?php echo BASEURL . '/' . $produto->imagem; ?>" class="imagem-produto">
                <?php else: ?>
                    <i class="fas fa-box-open" style="font-size:40px"></i>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" name="descricao" id="descricao"
                          placeholder="Deixe uma descrição do Produto!"><?php echo isset($produto->id) ? $produto->descricao : ''; ?></textarea>
            </div>
        </div>

    </div><!--end row-->

    <div class="row">
        <div class="col-md-12">
            <div class="form-group" style="background:#fffcf5">
                <label for="ativo">
                    Ativo: <small style="opacity:0.80">Mostrar em vendas</small>
                    <input
                        id="ativo"
                        name="deleted_at"
                        type="checkbox"
                        class="form-control"
                        <?php if (isset($produto->id) && is_null($produto->deleted_at)):?>
                           checked
                        <?php endif;?>
                   checked>
                </label>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success btn-sm" style="float:right"
            onclick="return salvarProduto()">
        <i class="fas fa-save"></i> Salvar
    </button>
</form>

<br>
<br>

<script src="<?php echo BASEURL; ?>/public/js/jquery-te-1.4.0.min.js"></script>
<script>
    // Anula duplo click em salvar
    anulaDuploClick($('form'));
    $("#descricao").jqte({
        format: false,
        ul: false,
        ol: false,
        rule: false,
        link: false,
        remove: false,
        outdent: false,
        underline: false,
        u: false,
        title: false,
        sup: false,
        sub: false,
        source: false,
        right: false,
        left: false,
        color:false,
        bold: false,
        remove: false,
        p: false,
        fsize: false,
        center: false,
        indent: false,
        unlink: false,
        strike: false,
        i: false,
        b: false
    });

    $(function () {
        jQuery('.campo-moeda')
            .maskMoney({
                prefix: 'R$ ',
                allowNegative: false,
                thousands: '.', decimal: ',',
                affixesStay: false
            });
    });

    $("#ativo").click(function() {
        if ( ! $(this).is(':checked')) {
            modalValidacao('Validação', '<small>Ao desativar este Produto ele não será apresentado nas Vendas!</small>');
        }
    })
</script>
