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
    .desativado {
        color: #cc0033;
    }
</style>

<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-box-open"></i> Produtos</h5>
        </div>
        <!-- Mostra as mensagens de erro-->
        <?php FlashMessage::show(); ?>

        <table class="table tabela-ajustada table-striped" style="width:100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Ativo</th>
                <th>R$ Preço</th>
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
                    
                    <td class="<?php echo (is_null($produto->deleted_at)) ? 'ativo' : 'desativado'; ?>">
                            <?php echo (is_null($produto->deleted_at)) ? 'Sim' : 'Não'; ?>
                        </td>


                    <td><?php echo real($produto->preco); ?></td>

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
                                <?php if (is_null($produto->deleted_at)): ?>
                                <button class="dropdown-item" href="#"
                                                onclick="modalAtivarEdesativarProduto('<?php echo $produto->id; ?>', '<?php echo $produto->nome; ?>', 'desativar')">
                                            <i class="fas fa-window-close"></i> Desativar
                                        </button>

                                    <?php else: ?>

                                <button class="dropdown-item" href="#"
                                                onclick="modalAtivarEdesativarProduto('<?php echo $produto->id; ?>', '<?php echo $produto->nome; ?>', 'ativar')">
                                            <i class="fas fa-square"></i> Ativar
                                </button>
                                <?php endif; ?>
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-trash-alt" style="color:#cc6666"></i> Excluir
                                </a> -->

                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

            <tfoot></tfoot>
        </table>

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
<!--Modal Desativar e ativar Clientes-->
<?php Modal::start([
    'id' => 'modalDesativarProduto',
    'width' => 'modal-lg',
    'title' => 'Imagem do Produto'
    // 'title' => '<i class="fas fa-user-tie" style="color:#ad54da"></i>'
]); ?>
<div id="modalConteudo">
    <p id="nomeProduto"></p>

    <center>
        <set-modal-button class="set-modal-button"></set-modal-button>
        <button class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="fas fa-window-close"></i> Não
        </button>
    </center>
</div>
<?php Modal::stop(); ?>



<div id="formulario"></div>

<?php Modal::stop(); ?>

<?php Modal::start([
    'id' => 'modalImagemProduto',
    'width' => 'modal-lg',
    'title' => 'Imagem do Produto'
]); ?>

<div id="containerModalImagemProduto"></div>

<?php Modal::stop(); ?>

<script>
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


//Desativar produto

    function modalAtivarEdesativarProduto(id, produto, operacao) {
        if (operacao == 'desativar') {
            $("#nomeProduto").html('Tem certeza que deseja desativar o produto ' + produto + '?');
            $("set-modal-button").html('<button class="btn btn-sm btn-success" id="buttonDesativarProduto" data-id-produto="" onclick="desativarProduto(this)"><i class="far fa-check-circle"></i> Sim</button>');

        } else if (operacao == 'ativar') {
            $("set-modal-button").html('<button class="btn btn-sm btn-success" id="buttonDesativarProduto" data-id-produto="" onclick="ativarProduto(this)"><i class="far fa-check-circle"></i> Sim</button>');
            $("#nomeProduto").html('Você deseja ativar o produto ' + produto + '?');
        }

        $("#modalDesativarProduto").modal({backdrop: 'static'});
        document.querySelector("#buttonDesativarProduto").dataset.idProduto = id;
    }

    function desativarProduto(elemento) {
        modalValidacao('Validação', 'Desativando Produto...');
        id = elemento.dataset.idProduto;

        var rota = getDomain() + "/produto/desativarProduto/" + id;
        $.get(rota, function (data, status) {
            var dados = JSON.parse(data);
            if (dados.status == true) {
                location.reload();
                //$("#modalDesativarCliente .close").click();
            }
        });
    }

    function ativarProduto(elemento) {
        modalValidacao('Validação', 'Ativando Produto...');
        id = elemento.dataset.idProduto;

        var rota = getDomain() + "/produto/ativarProduto/" + id;
        $.get(rota, function (data, status) {
            var dados = JSON.parse(data);
            if (dados.status == true) {
                location.reload();
                //$("#modalDesativarCliente .close").click();
            }
        });
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
