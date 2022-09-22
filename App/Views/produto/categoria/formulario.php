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
      action="<?php echo isset($produto->id) ? BASEURL . '/categoriaProduto/update' : BASEURL . '/categoriaProduto/save'; ?>"
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
                       placeholder="Digite o nome da categoria!"
                       value="<?php echo isset($produto->id) ? $produto->nome : '' ?>">
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
</script>
