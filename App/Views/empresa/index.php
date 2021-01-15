<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal; ?>

<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-store"></i> Empresas</h5>
        </div>

        <table id="example" class="table tabela-ajustada table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Data</th>
                <th style="text-align:right;padding-right:0">
                    <?php $rota = BASEURL . '/empresa/modalFormulario'; ?>
                    <button onclick="modalFormularioEmpresa('<?php echo $rota; ?>', null);"
                            class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i>

                    </button>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($empresas as $empresa): ?>
                <tr>
                    <td><?php echo $empresa->nome; ?></td>
                    <td><?php echo $empresa->email; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($empresa->created_at)); ?></td>

                    <td style="text-align:right">
                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                onclick="modalFormularioEmpresa('<?php echo $rota; ?>', '<?php echo $empresa->id; ?>');">
                            <i class="fas fa-cogs"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tfoot></tfoot>
        </table>

        <br>

    </div>
</div>

<?php Modal::start([
    'id' => 'modalEmpresa',
    'width' => 'modal-lg',
    'title' => 'Cadastrar Empresa'
]); ?>

<div id="formulario"></div>

<?php Modal::stop(); ?>

<script>
    function modalFormularioEmpresa(rota, id) {
        var url = "";

        if (id) {
            url = rota + "/" + id;
        } else {
            url = rota;
        }

        $("#formulario").html("<center><h3>Carregando...</h3></center>");
        $("#modalEmpresa").modal({backdrop: 'static'});
        $("#formulario").load(url);
    }
</script>
