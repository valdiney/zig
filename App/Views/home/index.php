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
                  <i class="nc-icon nc-globe text-warning"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Capacity</p>
                  <p class="card-title">150GB<p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-refresh"></i>
              Update Now
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
                  <i class="nc-icon nc-globe text-warning"></i>
                </div>
              </div>
              <div class="col-7 col-md-8">
                <div class="numbers">
                  <p class="card-category">Capacity</p>
                  <p class="card-title">150GB<p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-refresh"></i>
              Update Now
              

            </div>
          </div>
        </div>
      </div>

   

</div>

<div class="row">

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body ">
            <canvas class="grafico" id="grafico-tipo-pagamento" width="400" height="170"></canvas>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-refresh"></i>
              Update Now
            </div>
          </div>
        </div>
      </div>

       <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-body ">
            <canvas class="grafico" id="grafi-vendas-por-dia" width="400" height="230"></canvas>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-refresh"></i>
              Update Now
            </div>
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
    labels: ["2015-01", "2015-02", "2015-03", "2015-04", "2015-05", "2015-06", "2015-07", "2015-08", "2015-09", "2015-10", "2015-11", "2015-12"],
    datasets: [{
      label: '# of Tomatoes',
      data: [12, 19, 3, 5, 2, 3, 20, 3, 5, 6, 2, 1],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: false,
    scales: {
      xAxes: [{
        ticks: {
          maxRotation: 90,
          minRotation: 80
        }
      }],
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});
</script>