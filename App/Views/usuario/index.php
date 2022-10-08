<!--Usando o Html Components-->
<?php

use App\Config\ConfigPerfil;
use System\HtmlComponents\FlashMessage\FlashMessage;
use System\HtmlComponents\Modal\Modal;
use System\Session\Session;

?>

<style type="text/css">
    .imagem-perfil {
        width: 40px;
        height: 40px;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
    }
</style>

<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-users"></i> Usuários</h5>
        </div>
        <!-- Mostra as mensagens de erro-->
        <?php FlashMessage::show(); ?>

        <?php if (count($usuarios) > 0): ?>
            <table id="example" class="table tabela-ajustada table-striped" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th class="hidden-when-mobile">E-mail</th>
                    <th>Perfil</th>
                    <th>Ativo</th>
                    <th style="text-align:right;padding-right:0">
                        <?php $rota = BASEURL . '/usuario/modalFormulario'; ?>
                        <?php if (Session::get('idPerfil') != ConfigPerfil::vendedor()): ?>
                            <button onclick="modalUsuarios('<?php echo $rota; ?>', false);"
                                    class="btn btn-sm btn-success" title="Novo Usuário!">
                                <i class="fas fa-plus"></i>
                            </button>
                        <?php endif; ?>
                    </th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td>
                            <?php if (!is_null($usuario->imagem) && $usuario->imagem != ''): ?>
                                <center>
                                    <img src="<?php echo BASEURL . '/' . $usuario->imagem; ?>" width="40" class="imagem-perfil">
                                </center>
                            <?php else: ?>
                                <center><i class="fas fa-user" style="font-size:40px"></i></center>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $usuario->nome; ?></td>
                        <td class="hidden-when-mobile"><?php echo $usuario->email; ?></td>
                        <td><?php echo $usuario->perfil; ?></td>
                        <td class="<?php echo (is_null($usuario->deleted_at)) ? 'ativo' : 'desativado'; ?>">
                            <?php echo (is_null($usuario->deleted_at)) ? 'Sim' : 'Não'; ?>
                        </td>
                        <td style="text-align:right">

                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button"
                                        class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cogs"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                    <button class="dropdown-item" href="#"
                                            onclick="modalUsuarios('<?php echo $rota; ?>', <?php echo $usuario->id; ?>);">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>

                                    <?php if (is_null($usuario->deleted_at)): ?>

                                        <button class="dropdown-item" href="#"
                                                onclick="modalAtivarEdesativarUsuario('<?php echo $usuario->id; ?>', '<?php echo $usuario->nome; ?>', 'desativar')">
                                            <i class="fas fa-window-close"></i> Desativar
                                        </button>

                                    <?php else: ?>

                                        <button class="dropdown-item" href="#"
                                                onclick="modalAtivarEdesativarUsuario('<?php echo $usuario->id; ?>', '<?php echo $usuario->nome; ?>', 'ativar')">
                                            <i class="fas fa-square"></i> Ativar
                                        </button>

                                    <?php endif; ?>

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
                Poxa, ainda não há nenhum Cliente cadastrado! <br>
                <?php $rota = BASEURL . '/usuario/modalFormulario'; ?>
                <button
                    onclick="modalUsuarios('<?php echo $rota; ?>', null);"
                    class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i>
                    Cadastrar Usuário
                </button>
            </center>
        <?php endif; ?>

        <br>

    </div>
</div>

<?php Modal::start([
    'id' => 'modalUsuarios',
    'width' => 'modal-lg',
    'title' => 'Cadastrar Usuários'
]); ?>

<div id="formulario"></div>

<?php Modal::stop(); ?>

<!--Modal Desativar e ativar usuários-->
<?php Modal::start([
    'id' => 'modalDesativarUsuario',
    'width' => 'modal-sm',
    'title' => '<i class="fas fa-user-tie" style="color:#ad54da"></i>'
]); ?>
<div id="modalConteudo">
    <p id="nomeUsuario"></p>

    <center>
        <set-modal-button class="set-modal-button"></set-modal-button>
        <button class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="fas fa-window-close"></i> Não
        </button>
    </center>
</div>
<?php Modal::stop(); ?>

<script>
    function modalUsuarios(rota, usuarioId) {
        var url = "";

        if (usuarioId) {
            url = rota + "/" + usuarioId;
        } else {
            url = rota;
        }

        $("#formulario").html("<center><h3>Carregando...</h3></center>");
        $("#modalUsuarios").modal({backdrop: 'static'});
        $("#formulario").load(url);
    }

    function modalAtivarEdesativarUsuario(id, nome, operacao) {
        if (operacao == 'desativar') {
            $("#nomeUsuario").html('Tem certeza que deseja desativar o usuario ' + nome + '?');
            $("set-modal-button").html('<button class="btn btn-sm btn-success" id="buttonDesativarUsuario" data-id-usuario="'+id+'" onclick="desativarUsuario(this)"><i class="far fa-check-circle"></i> Sim</button>');

        } else if (operacao == 'ativar') {
            $("#nomeUsuario").html('Você deseja ativar o usuário ' + nome + '?');
            $("set-modal-button").html('<button class="btn btn-sm btn-success" id="buttonDesativarUsuario" data-id-usuario="'+id+'" onclick="ativarUsuario(this)"><i class="far fa-check-circle"></i> Sim</button>');
        }

        $("#modalDesativarUsuario").modal({backdrop: 'static'});
        document.querySelector("#buttonDesativarUsuario").dataset.idCliente = id;
    }

    function desativarUsuario(elemento) {
        modalValidacao('Validação', 'Desativando usuário...');
        id = elemento.dataset.idUsuario;

        var rota = getDomain() + "/usuario/desativarUsuario/" + id;
        $.get(rota, function (data, status) {
            var dados = JSON.parse(data);
            if (dados.status == true) {
                location.reload();
                //$("#modalDesativarUsuario .close").click();
            }
        });
    }

    function ativarUsuario(elemento) {
        modalValidacao('Validação', 'Ativando usuário...');
        id = elemento.dataset.idUsuario;

        var rota = getDomain() + "/usuario/ativarUsuario/" + id;
        $.get(rota, function (data, status) {
            var dados = JSON.parse(data);
            if (dados.status == true) {
                location.reload();
                //$("#modalDesativarUsuario .close").click();
            }
        });
    }
</script>
