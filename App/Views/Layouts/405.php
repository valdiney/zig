<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="utf-8">
    <title>Classe ou método não existe</title>
    <style type="text/css">
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body,
        #main {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f7f7f7;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        }

        #main {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        #main-title {
            font-size: 200px;
            font-weight: 100;
            opacity: .15;
        }

        #main-subtitle {
            padding-bottom: 10px;
            opacity: 0.60;
            font-weight: 100;
        }
    </style>
</head>

<body>
<main role="main" id="main">
    <div>
        <h1 id="main-title">405</h1>
        <h3 id="main-subtitle">Poxa! Classe ou método não encontrado!</h3>
        <i style="opacity:0.80;color:#cc0033">
            <?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
        </i>
    </div>
</main>
</body>

</html>
