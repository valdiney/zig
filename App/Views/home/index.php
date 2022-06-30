<?php use System\HtmlComponents\Charts\Doughnut; ?>
<style>
    .imagem-perfil {
        width: 30px;
        height: 30px;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
    }
    .tbody-totalVendasPorUsuariosNoMes tr td {
        font-size:10px!important;
    }
    .produtos-mais-vendidos {
        overflow-y: scroll;
        height:258px;
    }
    .produtos-mais-vendidos::-webkit-scrollbar-track {
        background-color: white;
    }
    .produtos-mais-vendidos::-webkit-scrollbar {
        width: 10px;
        background: #8d8d96;
    }
    .produtos-mais-vendidos::-webkit-scrollbar-thumb {
        background: #8d8d96;
        border-radius:5px;
    }
    .produtos-mais-vendidos::-webkit-input-placeholder {
        color: #8198ac;
    }
    @media only screen and (max-width: 600px) {
        .totalVendasPorUsuariosNoMes {
            overflow-x: scroll;
        }
        .imagem-perfil {
            width: 20px;
            height: 20px;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
        }
    }
</style>

<div class="row">

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fas fa-coins" style="color:#212120"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category" style="font-size:12px">Vendas deste mês</p>
                            <p class="card-title" style="font-size:15px">
                                R$ <?php echo real($faturamentoDeVandasNoMes); ?> <br>
                                <small style="font-size:11px;opacity:0.40">
                                    Mês de <?php echo mesesPorExtensoEnumeroDoMes(date('m')); ?>
                                </small>
                            <p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <i class="fas fa-coins" style="color:#048e6d"></i>
                    <small>Mês anterior <b>R$ <?php echo real($faturamentoDeVandasMesAnterior); ?></b></small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fas fa-coins" style="color:#212120"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category" style="font-size:12px">Vendas do dia</p>
                            <p class="card-title" style="font-size:15px">
                                R$ <?php echo real($faturamentoDeVandasNoDia); ?> <br>
                                <small style="font-size:11px;opacity:0.40">
                                    Hoje, <?php echo diaSemana(date('d/m/Y')); ?>
                                </small>
                            <p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <i class="fas fa-coins" style="color:#048e6d"></i>
                    <small>Dia anterior <b>R$ <?php echo real($faturamentoDeVandasNoDiaAnterior); ?></b></small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fas fa-user-tie" style="color:#212120"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category" style="font-size:12px;">Clientes</p>
                            <p class="card-title" style="font-size:15px">
                            Ativos: <?php echo $clientesCadastrados->ativos; ?><p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <i class="fas fa-user-tie" style="color:#048e6d"></i>
                    <small>Clientes inativos <b><?php echo $clientesCadastrados->inativos; ?></b></small>
                    </b></small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fas fa-box-open" style="color:#212120"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category" style="font-size:12px">Produtos</p>
                            <p class="card-title" style="font-size:15px">
                                Ativos: <?php echo $produtosCadastrados->ativos; ?><p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <i class="fas fa-box-open" style="color:#048e6d"></i>
                    <small>Produtos inativos <b><?php echo $produtosCadastrados->inativos; ?></b></small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body">
                <center>
                    Vendas por dia.
                    <small style="opacity:0.70">Ultimos 30 dias</small>
                </center>
                <canvas class="grafico" id="grafi-vendas-por-dia" width="400" height="185"></canvas>
            </div>
            <div class="card-footer ">
                <hr>
                <!--<div class="stats">
                  <i class="fa fa-refresh"></i>
                  Update Now
                </div>-->
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body">
                <center>
                    Vendas por dia.
                    <small style="opacity:0.70">Ultimos 30 dias</small>
                </center>
                <canvas class="grafico" id="grafi-valor-vendas-por-dia" width="400" height="185"></canvas>
            </div>
            <div class="card-footer ">
                <hr>
                <!--<div class="stats">
                  <i class="fa fa-refresh"></i>
                  Update Now
                </div>-->
            </div>
        </div>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body">
                <center>
                    Meios de pagamento.
                    <small style="opacity:0.70">Ultimos 30 dias</small>
                </center>
                <canvas class="grafico" id="grafico-tipo-pagamento" width="400" height="186"></canvas>
            </div>
            <div class="card-footer ">
                <hr>
                <!--<div class="stats">
                  <i class="fa fa-refresh"></i>
                  Update Now
                </div>-->
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body produtos-mais-vendidos">
                <center>
                    (6) Produtos mais vendidos.
                    <small style="opacity:0.70">
                        Mês de <?php echo mesesPorExtensoEnumeroDoMes(date('m')); ?>
                    </small>
                </center>

                <?php if (count($produtosMaisVendidosNoMes) > 0): ?>
                    <table class="table tabela-ajustada vendas_por_vendedores table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Produto</th>
                            <th>QTD</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($produtosMaisVendidosNoMes as $produto): ?>
                            <tr>
                                <td title="<?php echo $produto->nome; ?>">
                                    <?php if (!is_null($produto->imagem) && $produto->imagem != ''): ?>
                                        <img class="imagem-perfil" src="<?php echo BASEURL . '/' . $produto->imagem; ?>">
                                    <?php else: ?>
                                        <i class="fas fa-box-open" style="font-size:20px"></i>
                                    <?php endif; ?>
                                </td>

                                <td><?php echo $produto->nome;?></td>
                                <td><?php echo $produto->quantidade;?></td>
                                <td><?php echo reaL($produto->total);?></td>

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
            <div class="card-footer ">
                <hr>
                <!--<div class="stats">
                  <i class="fa fa-refresh"></i>
                  Update Now
                </div>-->
            </div>
        </div>
    </div><!--end vendas por usuarios-->

    <div class="col-lg-12 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body totalVendasPorUsuariosNoMes">
                <center>
                    Vendas por vendedores.
                    <small style="opacity:0.70">
                        Mês de <?php echo mesesPorExtensoEnumeroDoMes(date('m')); ?>
                    </small>
                </center>

                <?php if (count($totalVendasPorUsuariosNoMes) > 0): ?>
                    <table class="table tabela-ajustada vendas_por_vendedores table-striped">
                        <thead>
                        <tr class="tr-header-vendas-por-usuarios">
                            <th>#</th>
                            <th>Total</th>
                            <th>Dinheiro</th>
                            <th>Crédito</th>
                            <th>Débito</th>
                            <th>Boleto</th>
                            <th>Pix</th>
                        </tr>
                        </thead>
                        <tbody class="tbody-totalVendasPorUsuariosNoMes">
                        <?php foreach ($totalVendasPorUsuariosNoMes as $venda): ?>
                            <tr>
                                <td title="<?php echo $venda->nomeUsuario; ?>">
                                    <?php if (!is_null($venda->imagem) && $venda->imagem != ''): ?>
                                        <img class="imagem-perfil" src="<?php echo BASEURL . '/' . $venda->imagem; ?>">
                                    <?php else: ?>
                                        <i class="fa fa-user" style="font-size:30px"></i>
                                    <?php endif; ?>
                                </td>

                                <td>R$ <?php echo real($venda->valor); ?></td>

                                <?php if (!is_null($venda->Dinheiro)): ?>
                                    <td>R$ <?php echo real($venda->Dinheiro); ?></td>
                                <?php else: ?>
                                    <td><small>Não consta</small></td>
                                <?php endif; ?>

                                <?php if (!is_null($venda->Credito)): ?>
                                    <td>R$ <?php echo real($venda->Credito); ?></td>
                                <?php else: ?>
                                    <td><small>Não consta</small></td>
                                <?php endif; ?>

                                <?php if (!is_null($venda->Debito)): ?>
                                    <td>R$ <?php echo real($venda->Debito); ?></td>
                                <?php else: ?>
                                    <td><small>Não consta</small></td>
                                <?php endif; ?>

                                <?php if (!is_null($venda->Boleto)): ?>
                                    <td>R$ <?php echo real($venda->Boleto); ?></td>
                                <?php else: ?>
                                    <td><small>Não consta</small></td>
                                <?php endif; ?>

                                <?php if (!is_null($venda->Pix)): ?>
                                    <td>R$ <?php echo real($venda->Pix); ?></td>
                                <?php else: ?>
                                    <td><small>Não consta</small></td>
                                <?php endif; ?>
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
            <div class="card-footer ">
                <hr>
                <!--<div class="stats">
                  <i class="fa fa-refresh"></i>
                  Update Now
                </div>-->
            </div>
        </div>
    </div><!--end vendas por usuarios-->


    <div class="col-lg-12 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body totalVendasPorUsuariosNoMes">
                <center>
                    Vendas por mês em
                    <small style="opacity:0.70">
                        <?php echo date('Y');?>
                    </small>
                </center>

                <?php if (count($totalVendasPorUsuariosNoMes) > 0): ?>
                    <table class="table tabela-ajustada vendas_por_vendedores table-striped">
                        <thead>
                        <tr class="tr-header-vendas-por-usuarios">
                            <th>Mês</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody class="tbody-totalVendasPorUsuariosNoMes">
                        <?php foreach ($vendasPorMesNoAno as $mes): ?>
                            <tr>
                                <td>
                                    <?php echo mesesPorExtensoEnumeroDoMes($mes->mes);?>
                                </td>

                                <td>
                                    R$ <?php echo real($mes->total);?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php else: ?>
                    <br><br><br>
                    <center>
                        <i class="fas fa-sad-tear" style="font-size:40px;opacity:0.70"></i>
                        <br><br>
                        <h6 style="opacity:0.70">Inda não houve vendas este ano!</h6>
                    </center>
                <?php endif; ?>
            </div>
            <div class="card-footer ">
                <hr>
                <!--<div class="stats">
                  <i class="fa fa-refresh"></i>
                  Update Now
                </div>-->
            </div>
        </div>
    </div><!--end vendas por usuarios-->


</div>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>
<script src="<?php echo BASEURL; ?>/public/assets/chartjs/dist/Chart.min.js"></script>

<?php Doughnut::start(
    'grafico-tipo-pagamento',
    $percentualMeiosDePagamento->medias,
    $percentualMeiosDePagamento->legendas,
    ["#a0d2ae", "#98c0d5", "#dbb4dc", "#d0b9ae", "#73b1a2"]
); ?>
<script>
    /*$(".vendas_por_vendedores tbody td").each(function() {
      console.log($(this).text());
    });*/
    var ctx = document.getElementById("grafi-vendas-por-dia");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($quantidadeDeVendasRealizadasPorDia as $valor):?>
                <?php echo "\"{$valor->data}\",";?>
                <?php endforeach?>
            ],
            datasets: [{
                label: 'Quantidade Vendido',
                data: [
                    <?php foreach ($quantidadeDeVendasRealizadasPorDia as $valor):?>
                    <?php echo $valor->quantidade . ',';?>
                    <?php endforeach?>
                ],
                backgroundColor: '#00cccc',
                borderColor: '#255949',
                borderWidth: 1
            }
            ]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    ticks: {
                        maxRotation: 90,
                        minRotation: 80
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                        min: 0
                    }
                }]
            }
        }
    });

    ////////////////////////////////////////////////////////
    var ctx = document.getElementById("grafi-valor-vendas-por-dia");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                <?php foreach ($valorDeVendasRealizadasPorDia as $valor):?>
                <?php echo "\"{$valor->data}\",";?>
                <?php endforeach?>
            ],
            datasets: [{
                label: 'Valor Vendido',
                data: [
                    <?php foreach ($valorDeVendasRealizadasPorDia as $valor):?>
                    <?php echo $valor->valor . ',';?>
                    <?php endforeach?>
                ],
                backgroundColor: '#a0d2ae',
                borderColor: '#087e5e',
                borderWidth: 1
            }
            ]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    ticks: {
                        maxRotation: 90,
                        minRotation: 80
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                        min: 0
                    }
                }]
            }
        }
    });
</script>
