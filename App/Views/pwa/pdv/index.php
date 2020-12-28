<!DOCTYPE html>
<html>
<head>
    <title>Lúcia ERP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/images/logo-light-text.png"/>
    <link rel="stylesheet" type="text/css"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <meta name="author" content="Valdney França">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:type" content="website">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#2dd1ac">

    <style>
        body {
            background: #fff;
            color: #444d5d
        }

        body, html {
            height: 100%
        }

        .card {
            margin-top: 30px;
            box-shadow: #cbcdc9 1px 1px 5px
        }

        .card h3 {
            color: #444d5d
        }

        .col-lg-12 {
            padding: 0
        }

        .card {
            border: 0;
            border-radius: 0;
            box-shadow: #fff 1px 1px 1px
        }

        .list-group li {
            border-left: 0 !important;
            border-right: 0 !important;
            border-bottom: 0 !important;
            width: 100% important
        }

        .the-my-circle {
            width: 60px;
            float: right
        }

        .img-perfil {
            float: left;
            width: 40px;
            border-radius: 50%;
            margin-right: 10px;
            margin-top: 10px
        }

        .theShow {
            display: block !important
        }

        .theNone {
            display: none !important
        }

        #menu {
            background: #fff;
            position: absolute;
            z-index: 2000000;
            height: 100%;
            display: none
        }

        .brand {
            padding: 2px;
            background: #f2f4f5;
            border-radius: 5px;
            border: 1px solid #2dd1ac
        }
    </style>

</head>
<body>

<!-- Just an image -->
<nav class="navbar navbar-light" style="background:#2dd1ac;">
		<span class="navbar-toggler btn-sm btn" style="padding:0;border:0;outline:none">
            <span class="navbar-toggler-icon" id="button-menu"></span>
            <span style="text-align:center!important;font-size:16px">ZigMoney</span>
        </span>
</nav>

<div class="col-lg-12" id="menu">
    <ul class="list-group">
        <li class="list-group-item" disabled style="opacity:0.40">Realizar vendas <small class="brand">Em breve</small>
        </li>
        <li class="list-group-item" disabled style="opacity:0.40">Produtos <small class="brand">Em breve</small></li>
        <li class="list-group-item" id="sair-do-app">Sair do App</li>
    </ul>
</div>

<div class="col-lg-12" style="margin-top:5px"></div>

<div class="container" style="margin-top:0;" id="app">

    <div class="row" id="controle-de-datas" style="display:none">
        <div class="col-lg-12" style="padding:10px">

            <center>
                <button class="btn" style="border:1px solid #d9dce1;margin-right:10px" id="btn-mes-anterior">
                    <i class="fas fa-chevron-left" style="float:left;line-height:30px;opacity:0.80;"></i>
                </button>

                <button class="btn" style="border:1px solid #d9dce1;">
                    <i class="fas fa-calendar-alt" style="float:left;line-height:30px;opacity:0.80"></i>
                    <span style="line-height:30px;margin-left:10px">
					        Mês: <span id="mostra-o-mes">{{date('m')}}</span>/2019
					   </span>
                </button>

                <button class="btn" style="border:1px solid #d9dce1;margin-left:10px">
                    <i class="fas fa-chevron-right" style="float:left;line-height:30px;opacity:0.80"
                       id="btn-mes-proximo"></i>
                </button>
            </center>

        </div>
    </div>

    <!-- As outras páginas são carregadas aqui-->
    <div id="carregar-conteudo"></div>

</div>
</div>

<div class="col-lg-12" style="margin-top:20px;"></div>

<script src="{{url('js/jquery.js')}}"></script>
<script>
    // Mostra o menu
    $("#button-menu").click(function () {
        $("#menu").toggle();
        $(".container").toggle();
    });

</script>

</body>
</html>
