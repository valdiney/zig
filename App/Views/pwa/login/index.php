<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <title>ZigMoney</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/images/logo-light-text.png"/>
    <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/public/assets/css/bootstrap.min.css">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">

    <meta name="author" content="Valdney França">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:type" content="website">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#2dd1ac">

    <style>
        #card-login {
            margin-top: 10%;
            background: 0 0;
            border: 0 !important;
            box-shadow: 0 0 0
        }

        #button-entrar {
            background: #22b7c1;
            color: #fff;
            font-weight: 700;
            border: 0
        }

        body {
            background: #3c9
        }

        body, html {
            height: 100%
        }

        .card-body {
            border: 0 !important;
            border-right: 0
        }

        .close-modal {
            display: none !important
        }
    </style>

</head>
<body>

<div class="container">

    <div class="row z-index-alto">

        <div class="col-md-12">

            <div class="card" id="card-login">
                <div class="card-body">

                    <div class="text-center"><h2 style="color:white;">ZigMoney</h2></div>
                    <br>

                    <div class="form-group">
                        <input type="email" class="form-control" id="email" placeholder="E-mail de acesso!">
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="password" placeholder="Senha de acesso!">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-basic block" id="button-entrar" style="width:100%"
                                onclick="logar(this)">
                            Entrar
                        </button>
                    </div>

                </div>
            </div>

        </div>

    </div><!-- end row-->
</div><!--end container-->
</div><!--end app-->

<div id="ex1" class="modal" style="height:100px">
    <center><p><b>Usuário não encontrado!</b></p></center>
    <a href="#" rel="modal:close" class="btn btn-block btn-primary btn-sm">Tentar novamente</a>
</div>

<?php require_once('App/Views/pwa/modalValidacao.php'); ?>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>
<script src="<?php echo BASEURL; ?>/public/assets/js/core/bootstrap.min.js"></script>
<script src="<?php echo BASEURL; ?>/public/js/helpers.js"></script>

<script>

    function logar(elemento) {
        modalValidacao('vadilacao', 'Verificando...');

        $.post("http://localhost:8000/pwa/logar", {
            email: $("#email").val(),
            password: $("#password").val()

        }, function (result) {
            var objeto = JSON.parse(result);
            if (objeto.sucess == true) {
                localStorage.setItem('token', objeto.token);
                window.location.href = 'http://localhost:8000/pwa/pdv';
            } else {
                modalValidacao('vadilacao', 'Email ou senha incorreto!');
            }

        });
    }

</script>

</body>
</html>
