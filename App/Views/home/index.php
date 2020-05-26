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
            <canvas class="grafico" id="grafico" width="400" height="170"></canvas>
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
    [10, 20, 30],
    ['Dinheiro', 'Credito', 'Debito'], 
    ["#83e6cd","#9be6e6","#ffe6b5"]
);
?>