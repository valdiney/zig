<!--Usando o Html Components-->
<?php use System\HtmlComponents\Modal\Modal; ?>


<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title">
                <?php iconFilter(); ?>
                Filtros
            </h5>
        </div>

        <form method="POST" action="<?php echo BASEURL; ?>/pedido/tabelaDepedidosChamadosViaAjax" id="form">

            <!-- token de segurança -->
            <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="periodo_de">Período de</label>
                        <input type="date" class="form-control" name="de" id="periodo_de"
                               value="<?php echo $dates['start_of_month'] ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="periodo_ate">Período até</label>
                        <input type="date" class="form-control" name="ate" id="periodo_ate"
                               value="<?php echo $dates['today'] ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipo_data">Pesquisar pelo tipo</label>
                        <select name="data_tipo" id="data_tipo" class="form-control">
                            <option value="">Não filtrar por data</option>
                            <option value="pedido">Data de pedido</option>
                            <option value="entrega">Data de entrega</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ativo">Situação</label>
                        <select name="situacao_pedido" id="situacao_pedido" class="form-control">
                            <option value="">Todas as situações</option>
                            <?php foreach ($situacoesPedidos as $situacaoPedido): ?>
                                <option value="<?php echo $situacaoPedido->id; ?>">
                                    <?php echo $situacaoPedido->legenda; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label for="id_usuario">Clientes</label>
                        <select class="form-control" name="id_cliente" id="id_cliente_filtro">
                            <option value="todos">Todos</option>
                            <?php foreach ($clientes as $cliente) : ?>
                                <option value="<?php echo $cliente->id; ?>">
                                    <?php echo $cliente->nome; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-sm btn-success text-right pull-right" id="buscar-pedidos"
                            style="margin-left:10px">
                        <i class="fas fa-search"></i> Buscar
                    </button>

                </div>

            </div>
            <!--end row-->
        </form>

        <br>

    </div>
</div>

<div class="row">
    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-shopping-basket"></i> Pedidos</h5>
        </div>
        <div id="append-pedidos"></div>
        <br>
    </div>
</div>
<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>
<script src="<?php echo BASEURL; ?>/public/js/helpers.js"></script>

<?php Modal::start([
    'id' => 'modalPedidos',
    'width' => 'modal-lg',
    'title' => 'Cadastrar Pedido'
]); ?>

<div id="formulario"></div>

<?php Modal::stop(); ?>

<script>
    function modalFormularioPedido(rota, id) {
        var url = "";

        if (id) {
            url = rota + "/" + id;
        } else {
            url = rota;
        }

        $("#formulario").html("<center><h3>Carregando...</h3></center>");
        $("#modalPedidos").modal({backdrop: 'static'});
        $("#formulario").load(url);
    }
</script>

<script>
    function alterarSituacaoPedido(idPedido, idSituacaoPedido) {
        var rota = getDomain() + "/pedido/alterarSituacaoPedido";

        modalValidacao('Validação', 'Aguarde...');
        $.post(rota, {
            '_token': '<?php echo TOKEN; ?>',
            'id_pedido': idPedido,
            'id_situacao_pedido': idSituacaoPedido,

        }, function (resultado) {
            var retorno = JSON.parse(resultado);
            if (retorno.status == true) {
                setTimeout(modalValidacaoClose, 800);
            }
        })

        return false;
    }

    $("#buscar-pedidos").click(function () {
        pedidos();
        return false;
    });

    pedidos();

    function pedidos() {
        $('#append-pedidos').html('<br><center><h3>Carregando...</h3></center>');
        var rota = $('#form').attr('action');
        $.post(rota,

            $('#form').serialize(),

            function (resultado) {
                $('#append-pedidos').empty();
                $('#append-pedidos').append(resultado);
            });
    }
</script>
