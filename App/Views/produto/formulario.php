<link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/public/css/jquery-te-1.4.0.css">
<style>
    #codigo::-webkit-outer-spin-button,
    #codigo::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
    #codigo[type=number] {
        -moz-appearance:textfield; /* Firefox */
    }
    .configuracao_produto {
        width:100%;
        padding-top:10px;
        margin-bottom:20px;
        border-bottom:1px solid #dddddd;
    }
    .quantidade-desablitado {
        opacity:0.50;
    }
</style>

<?php if (isset($produto->id) && !empty($produto->codigo)): ?>
    <div class="row">
        <div class="col-md-12 text-center" style="opacity:0.80;background:#fffcf5">
            <?php echo codigoDeBarrasParaSvg($produto->codigo); ?><br>
            <span style="font-size:12px;color:black;"><?php echo isset($produto->id) ? $produto->codigo : false;?></span>
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

        <div class="col-md-12 configuracao_produto">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ativo">
                            <small style="opacity:0.80">Mostrar este produto em vendas</small>
                            <input
                                id="ativo"
                                name="mostrar_em_vendas"
                                type="checkbox"
                                class="form-control"
                                <?php if (isset($produto->id) && $produto->mostrar_em_vendas == '1'):?>
                                checked
                                <?php endif;?>
                        <?php echo isset($produto->id) ? false : 'checked';?>>
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ativar_quantidade">
                            <small style="opacity:0.80">Habilitar quantidade deste produto</small>
                            <input
                                id="ativar_quantidade"
                                name="ativar_quantidade"
                                type="checkbox"
                                class="form-control"
                                <?php if (isset($produto->id) && $produto->ativar_quantidade == 1):?>
                                checked
                                <?php endif;?>
                            >
                        </label>
                    </div>
                </div>
            </div>

        </div>

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

        <div class="col-md-4 div-campo-quantidade quantidade-desablitado">
            <div class="form-group">
                <label for="quantidade">Quantidade *</label>
                <input type="number" class="form-control nome" name="quantidade" id="quantidade"
                       placeholder="Digite a quantidade..."
                       value="<?php echo isset($produto->id) ? $produto->quantidade : '' ?>"
                       onchange="alterarAquantidade(this.value)"
                       disabled>
            </div>
        </div>

        <?php //if (isset($produto->codigo) === false) { ?>
            <div class="col-md-6 mb-2">
                <div class="form-group">
                    <label for="nome">Código de barras</label>
                    <input type="number" class="form-control nome" name="codigo" id="codigo"
                        placeholder="Número do código de barras"
                        value="<?php echo isset($produto->codigo) ? $produto->codigo : '' ?>">
                        <p class="text-muted">
                            <small>Caso você não tenha um código de barras, deixe vazio para ser preenchido automaticamente!</small>
                        </p>
                </div>
            </div>
        <?php //} ?>

        <div class="col-md-4">
            <div class="form-group">
                <label for="imagem">Escolher Imagem do Produto</label>
                <input type="file" class="form-control" name="imagem" id="imagem"> <br>
                <img src="" class="imagem-produto" id="thumb" style="display:none">
                <?php if (isset($produto->id) && ! is_null($produto->imagem)): ?>
                    <img src="<?php echo BASEURL . '/' . $produto->imagem; ?>" class="imagem-produto _padrao">
                <?php else: ?>
                    <i class="fas fa-box-open _padrao" style="font-size:40px"></i>
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

    <?php if (isset($produto->id) && $produto->ativar_quantidade == 1):?>
        $(".div-campo-quantidade").removeClass('quantidade-desablitado');
        $("#quantidade").prop('disabled', false);
    <?php endif;?>

    $("#ativar_quantidade").click(function() {
        if ($(this).is(':checked')) {
            $(".div-campo-quantidade").removeClass('quantidade-desablitado');
            $("#quantidade").prop('disabled', false);
        } else {
            $(".div-campo-quantidade").addClass('quantidade-desablitado');
            $("#quantidade").prop('disabled', true);
        }
    })

    function alterarAquantidade(quantidade) {
        quantidade = Number(quantidade);
        if (quantidade <= 0) {
            $("#quantidade").val(1);
        }
    }

    $("#imagem").change(function() {
        let reader = new FileReader();
        let file = document.querySelector("#imagem");
        let photo = document.querySelector("#thumb");
        reader.onload = () => {
            photo.src = reader.result;
        }

        $("._padrao").hide();
        $("#thumb").show();
        reader.readAsDataURL(file.files[0]);
    })

    $("#imagem").change(function() {
        verificaExtensaoArquivo($(this).val());
    })
</script>
