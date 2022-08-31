<!--Usando o Html Components-->
<?php
use System\HtmlComponents\FlashMessage\FlashMessage;
use System\HtmlComponents\Modal\Modal;
?>

<style type="text/css">
    .imagem-produto {
        width: 40px;
        height: 40px;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
        border: 1px solid silver;
    }
    .with_deleted_at {
        opacity:0.70;
    }
    #containerModalImagemProduto img {
        display:block;
        margin:0 auto;
    }
    .imagem-produto:hover {
        border:1px solid #009966;
        cursor:pointer;
    }
</style>

<div class="row">
    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Pesquise por nome..."
                    onkeyup="pesquisarProdutoPorNome($(this).val())">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Pesquise por código de barras..."
                    onkeyup="pesquisarProdutoPorCodigoDeBarras($(this).val())">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-box-open"></i> Produtos</h5>
        </div>
        <!-- Mostra as mensagens de erro-->
        <?php FlashMessage::show(); ?>

        <div style="padding-left:20px;color:#999999">
            <small>Produto mais caro: R$ <?php echo real($informacoes->maisCaro);?></small> |
            <small>Produto mais barato: R$ <?php echo real($informacoes->maisBarato);?></small>
        </div>

        <hr>

        <div id="carregar-produtos"></div>

        <br>

    </div>
</div>

<?php Modal::start([
    'id' => 'modalFormulario',
    'width' => 'modal-lg',
    'title' => 'Cadastrar Produtos'
]); ?>

<div id="formulario"></div>

<?php Modal::stop(); ?>

<?php Modal::start([
    'id' => 'modalImagemProduto',
    'width' => 'modal-lg',
    'title' => 'Imagem do Produto'
]); ?>

<div id="containerModalImagemProduto"></div>

<?php Modal::stop(); ?>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>

<script>
    pesquisarProdutoPorNome(false);
    function pesquisarProdutoPorNome(nome) {
        $("#carregar-produtos").html("<center><h3>Carregando...</h3></center>");
        if (nome != '' || nome != false) {
            $("#carregar-produtos").load("produto/pesquisarProdutoPorNome/"+in64(nome));
        } else {
            $("#carregar-produtos").load("produto/pesquisarProdutoPorNome");
        }
    }

    function pesquisarProdutoPorCodigoDeBarras(codigo) {
        $("#carregar-produtos").html("<center><h3>Carregando...</h3></center>");
        if (codigo != '' || codigo != false) {
            $("#carregar-produtos").load("produto/pesquisarProdutoPorCodigoDeBarras/"+in64(codigo));
        } else {
            $("#carregar-produtos").load("produto/pesquisarProdutoPorCodigoDeBarras");
        }
    }

    function modalFormularioProdutos(rota, id) {
        var url = "";

        if (id) {
            url = rota + "/" + id;
        } else {
            url = rota;
        }

        $("#formulario").html("<center><h3>Carregando...</h3></center>");
        $("#modalFormulario").modal({backdrop: 'static'});

        $("#formulario").load(url);
    }

    function salvarProduto() {
        if ($('#nome').val() == '') {
            modalValidacao('Validação', 'Campo (Nome) deve ser preenchido!');
            return false;

        } else if ($('#preco_compra').val() == '') {
            modalValidacao('Validação', 'Campo (Preço de Compra) deve ser preenchido!');
            return false;

        } else if ($('#preco').val() == '') {
            modalValidacao('Validação', 'Campo (Preço) deve ser preenchido!');
            return false;
        }

        return true;
    }

    function modalImagemDoProduto(imagem, nome) {
        $("#modalImagemProduto").modal().show();
        var html = '<center><h3>'+nome+'<h3></center>';
            html += '<img src="'+imagem+'"/>';
        $("#containerModalImagemProduto").html(html);
    }
</script>
