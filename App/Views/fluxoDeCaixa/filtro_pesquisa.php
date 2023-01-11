<div class="row">
    <div class="col-lg-12 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="card-body">
                    <h5 class="card-title">
                        <?php iconFilter(); ?>
                        Filtros
                    </h5>
                </div>

                <form method="POST" action="<?php echo BASEURL; ?>/fluxoDeCaixa/tabelaFluxoDeCaixa" id="form">
                    <!-- token de segurança -->
                    <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="periodo_de">Período de</label>
                                <input type="date" class="form-control busca-sem-codigo" name="de" id="periodo_de"
                                value="<?php echo date('Y') . '-' . date('m') . '-' . '01' ?>">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <input class="w3-radio" type="radio" name="tipo_periodo" id="data_lancamento" value="lancamento"
                                    <?php //echo $checkedTipoEntrada;?>>
                                    <label>Data Lançamento</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="w3-radio" type="radio" name="tipo_periodo" id="data_vencimento" value="vencimento"
                                    <?php //echo $checkedTipoSaida;?>>
                                    <label>Data Vencimento</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="periodo_ate">Período até</label>
                                <input type="date" class="form-control busca-sem-codigo" name="ate" id="periodo_ate"
                                value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="id_usuario">Categorias</label>
                                <select class="form-control js-example-basic-single busca-sem-codigo" name="id_usuario" id="id_usuario">
                                    <option value="todos">Todas</option>
                                    <?php foreach ($usuarios as $usuario) : ?>
                                        <option value="<?php echo $usuario->id; ?>">
                                            <?php echo "<img class='img-flag' src='" . $usuario->imagem . "'>" . $usuario->nome; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>



                            <input type="hidden" id="retirarPDV" name="retirarPDV" value="0">

                            <button type="submit" class="btn btn-sm btn-success text-right pull-right" id="buscar-fluxo"
                                style="margin-left:10px">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                    </div>
                </form>
            </div>
        </div>
</div>
