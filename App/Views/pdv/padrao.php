<!--Usando o Html Components-->
<?php

use App\Views\Layouts\HtmlComponents\Modal;
use System\Session\Session;

?>
<style type="text/css">
    .imagem-perfil {
        width: 30px;
        height: 30px;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
    }

    @media only screen and (min-width: 600px) {
        #salvar-venda {
            margin-top: 25px;
        }
    }

    .card-two {
        margin-top: 10px;
        border-radius: 3px;
        box-shadow: none;
        border: 1px solid #dddddd;
        padding-left: 3px;
        padding-right: 3px;
    }

    .tabela-ajustada tr td {
        padding-top: 2px !important;
        padding-bottom: 2px !important;
        font-size: 12px;
    }

    .tabela-ajustada th {
        font-size: 13px !important;
    }
</style>

<div class="row">

    <div class="card col-lg-12 content-div">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-coins"></i> Registrar Venda</h5>

            <form method="post" action="<?php echo BASEURL; ?>/pdvPadrao/save">
                <div class="row">

                    <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="valor">R$ Valor *</label>
                            <input type="text" class="form-control campo-moeda valor" name="valor" id="valor"
                                   placeholder="00,00">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_meio_pagamento">Meios de pagamento *</label>
                            <select class="form-control" name="id_meio_pagamento" id="id_meio_pagamento">
                                <?php foreach ($meiosPagamentos as $pagamento): ?>
                                    <option value="<?php echo $pagamento->id; ?>">
                                        <?php echo $pagamento->legenda; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_usuario">Vendedor *</label>
                            <select class="form-control" name="id_usuario" id="id_usuario">
                                <?php foreach ($usuarios as $usuario): ?>
                                    <?php if ($usuario->id == Session::get('idUsuario')): ?>
                                        <option value="<?php echo $usuario->id; ?>" selected>
                                            <?php echo $usuario->nome; ?>
                                        </option>
                                    <?php else: ?>
                                        <option value="<?php echo $usuario->id; ?>">
                                            <?php echo $usuario->nome; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success text-right salvar-venda" id="salvar-venda">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>


<div class="row">
    <div class="card card-two col-lg-6 content-div">
        <div class="card-body">
            <h5 class="card-title" style="text-align:center">
                <i class="fas fa-cart-arrow-down" style="color:#00cc99"></i>
                Ultimas 10 vendas no dia!
            </h5>

            <center><small>Hoje: <?php echo date('d/m'); ?></small></center>

            <?php if (count($vendasGeralDoDia) > 0): ?>
                <table class="table tabela-ajustada table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor</th>
                        <th>Pagamento</th>
                        <th>Hora</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($vendasGeralDoDia as $venda): ?>
                        <tr>
                            <td><img class="imagem-perfil" src="<?php echo BASEURL . '/' . $venda->imagem; ?>"></td>
                            <td>R$ <?php echo number_format($venda->valor, 2, ',', '.'); ?></td>
                            <td><?php echo $venda->legenda; ?></td>
                            <td><?php echo $venda->data; ?>h</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <br><br><br>
                <center>
                    <i class="fas fa-sad-tear" style="font-size:40px;opacity:0.70"></i>
                    <br><br>
                    <h6 style="opacity:0.70">Não houve vendas hoje!</h6>
                </center>
            <?php endif; ?>
        </div>
    </div>

    <div class="card card-two col-lg-6 content-div">
        <div class="card-body">
            <h5 class="card-title" style="text-align:center">
                <i class="fas fa-cart-arrow-down" style="color:#00cc99;"></i>
                Vendido até o momento
            </h5>

            <center><small>Hoje: <?php echo date('d/m'); ?></small></center>

            <center style="margin-top:20px">
                <div>
                    <h3>R$ <?php echo number_format($totalVendasNoDia, 2, ',', '.'); ?></h3>
                    <?php foreach ($totalValorVendaPorMeioDePagamentoNoDia as $tipo): ?>
                        <?php if ($tipo->idMeioPagamento == 1): ?>
                            <span class="badge" style="background:#83e6cd;padding:5px">
			        			      <?php echo $tipo->legenda; ?> R$ <?php echo real($tipo->totalVendas); ?>
			        			 </span>
                        <?php elseif ($tipo->idMeioPagamento == 2): ?>
                            <span class="badge" style="background:#9be6e6;padding:5px">
			        			      <?php echo $tipo->legenda; ?> R$ <?php echo real($tipo->totalVendas); ?>
			        			 </span>
                        <?php elseif ($tipo->idMeioPagamento == 3): ?>
                            <span class="badge" style="background:#ff9b9b;padding:5px">
			        			      <?php echo $tipo->legenda; ?> R$ <?php echo real($tipo->totalVendas); ?>
			        			 </span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <br>
                <br>

                <?php if (is_null($totalVendaNoDiaAnterior)): ?>
                    <small>Nenhuma venda foi realizada ontem!</small>
                <?php else: ?>
                    <small>Vendido ontem: <b>R$ <?php echo real($totalVendaNoDiaAnterior); ?></b></small>
                <?php endif; ?>

            </center>
        </div>
    </div>
</div>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.salvar-venda').click(function () {
            if ($('.valor').val() == '') {
                modalValidacao('Validação', 'Campo (Valor) deve ser preenchido!');
                return false;
            }

            modalValidacao('Salvando', 'Processando...');
            $(".close").hide();

            return true;
        });
    });
</script>
