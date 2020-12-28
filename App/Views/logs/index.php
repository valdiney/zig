<style>
    .imagem-perfil {
        width: 30px;
        height: 30px;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
    }
</style>

<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-file-signature"></i> Log de acessos</h5>
        </div>
        <table id="example" class="table tabela-ajustada table-striped" style="width:100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Empresa</th>
                <th>Cliente</th>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($logs as $log) : ?>
                <tr>
                    <td>
                        <img class="imagem-perfil" src="<?php echo BASEURL . '/' . $log->usuario_imagem; ?>"
                             title="<?php echo $log->usuario_nome; ?>">
                    </td>
                    <td><?php echo $log->empresa_nome; ?></td>
                    <td><?php echo $log->usuario_nome; ?></td>
                    <td><?php echo $log->hora . ' ' . $log->data; ?></td>
                </tr>
            <?php endforeach; ?>
            <tfoot></tfoot>
        </table>


        <br>

    </div>
</div>
