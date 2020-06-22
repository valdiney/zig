<?php use App\Views\Layouts\HtmlComponents\Charts\Doughnut;?>

<div class="row">

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body ">
            <div class="row">
              <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                  <i class="fas fa-coins" style="color:#00cc99"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category" style="font-size:12px">Vendas deste mês</p>
                  <p class="card-title" style="font-size:15px">
                    R$ <?php echo real($faturamentoDeVandasNoMes);?> <br>
                    <small style="font-size:11px;opacity:0.40">
                      Mês de <?php echo mesesPorExtensoEnumeroDoMes(date('m'));?>
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
              <small>Mês anterior <b>R$ <?php echo real($faturamentoDeVandasMesAnterior);?></b></small>
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
                  <i class="fas fa-coins" style="color:#fc9898"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category" style="font-size:12px">Vendas do dia</p>
                  <p class="card-title" style="font-size:15px">
                    R$ <?php echo real($faturamentoDeVandasNoDia);?> <br>
                    <small style="font-size:11px;opacity:0.40">
                      Hoje, <?php echo diaSemana(date('d/m/Y'));?>
                    </small>
                  <p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fas fa-coins" style="color:#cf7474"></i>
              <small>Dia anterior <b>R$ <?php echo real($faturamentoDeVandasNoDiaAnterior);?></b></small>
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
                  <i class="fab fa-product-hunt" style="color:#99ccff"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category" style="font-size:12px">Produtos a venda</p>
                  <p class="card-title" style="font-size:15px">Ativos 10<p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fab fa-product-hunt" style="color:#99ccff"></i>
              <small>Produtos inativos <b>5</b></small>
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
                  <i class="fas fa-user-tie" style="color:#ad54da"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category" style="font-size:12px">Clientes</p>
                  <p class="card-title" style="font-size:15px">Ativos 7<p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fas fa-user-tie" style="color:#ad54da"></i>
              <small>Clientes inativos <b>3</b></small>
              

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
    
</div>

<script src="<?php echo BASEURL;?>/public/assets/chartjs/dist/Chart.min.js"></script>

<?php Doughnut::start(
  'grafico-tipo-pagamento',
  $percentualMeiosDePagamento->medias,
  $percentualMeiosDePagamento->legendas, 
  ["#83e6cd","#9be6e6","#ffe6b5"]
);?>


<script>
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
      label: 'Quantidade',
      data: [
        <?php foreach ($quantidadeDeVendasRealizadasPorDia as $valor):?>
          <?php echo $valor->quantidade .',';?>
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
</script>