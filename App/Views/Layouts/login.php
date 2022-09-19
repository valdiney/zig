<!DOCTYPE html>
<html>
<head>

    <?php if (getenv('APPLICATION_NAME')): ?>
        <link rel="shortcut icon" href="public/img/favicon_tonie.png"/>
    <?php else: ?>
        <link rel="shortcut icon" href="public/img/favicon.png"/>
    <?php endif; ?>

    <?php if (getenv('APPLICATION_NAME')): ?>
        <title><?php echo getenv('APPLICATION_NAME'); ?></title>
    <?php else: ?>
        <title>ZigMoney</title>
    <?php endif; ?>

    <meta charset="utf-8">
    <base href="<?php echo BASEURL; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/public/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>/public/css/login.css">
    <style type="text/css">
        body {
            background-image: url('<?php echo BASEURL; ?>/public/img/fundo_login.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: top center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        Bem vindo
                    </h5>
                    <?php $this->viewRender(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>
<script src="<?php echo BASEURL; ?>/public/assets/js/core/popper.min.js"></script>
<script src="<?php echo BASEURL; ?>/public/assets/js/core/bootstrap.min.js"></script>
<script src="<?php echo BASEURL; ?>/public/js/helpers.js"></script>

</body>
</html>
