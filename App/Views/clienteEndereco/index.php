<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal; ?>

<style type="text/css">
    .imagem-produto {
        width: 40px;
        height: 40px;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
        border: 1px solid silver;
    }
</style>

<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-map-marker-alt" style="color:#d4a8ea"></i>
                <?php echo $cliente->nome; ?>
            </h5>
        </div>

        <?php if (count($clienteEnderecos) > 0): ?>
            <table class="table tabela-ajustada table-striped" style="width:100%">
                <thead>
                <tr>
                    <th>CEP</th>
                    <th>Endereço</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th style="text-align:right;padding-right:0">
                        <?php $rota = BASEURL . '/clienteEndereco/modalFormulario'; ?>
                        <button
                            onclick="modalFormularioEndereco('<?php echo $rota; ?>', <?php echo $cliente->id; ?>, null);"
                            class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i>
                            Novo
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($clienteEnderecos as $endereco): ?>

                    <tr>
                        <td><?php echo $endereco->cep; ?></td>
                        <td><?php echo $endereco->endereco; ?></td>
                        <td><?php echo $endereco->bairro; ?></td>
                        <td><?php echo $endereco->cidade; ?></td>
                        <td><?php echo $endereco->estado; ?></td>

                        <td style="text-align:right">

                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button"
                                        class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cogs"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                    <?php $rota = BASEURL . '/clienteEndereco/modalFormulario'; ?>
                                    <button class="dropdown-item" href="#"
                                            onclick="modalFormularioEndereco('<?php echo $rota; ?>', <?php echo $cliente->id; ?>, <?php echo $endereco->id; ?>);">
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
            <center>
                <i class="far fa-grin-beam" style="font-size:50px;opacity:0.60"></i> <br> <br>
                Poxa, ainda não há endereços cadastrados para este Cliente! <br>
                <?php $rota = BASEURL . '/clienteEndereco/modalFormulario'; ?>
                <button
                    onclick="modalFormularioEndereco('<?php echo $rota; ?>', <?php echo $cliente->id; ?>, null);"
                    class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i>
                    Cadastrar Endereço
                </button>
            </center>
        <?php endif; ?>

        <br>

    </div>
</div>

<?php Modal::start([
    'id' => 'modalFormulario',
    'width' => 'modal-lg',
    'title' => 'Cadastrar Endereços'
]); ?>

<div id="formulario"></div>

<?php Modal::stop(); ?>

<script>
    function modalFormularioEndereco(rota, idCliente, id) {
        var url = "";

        if (id) {
            url = rota + "/" + idCliente + "/" + id;
        } else {
            url = rota + "/" + idCliente;
        }

        $("#formulario").html("<center><h3>Carregando...</h3></center>");
        $("#modalFormulario").modal({backdrop: 'static'});

        $("#formulario").load(url);
    }
</script>
