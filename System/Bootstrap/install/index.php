<?php

use System\HtmlComponents\FlashMessage\FlashMessage; ?>
<!DOCTYPE html>
<html>

<head>
  <?php if (getenv('APPLICATION_NAME')) : ?>
    <link rel="shortcut icon" href="public/img/favicon_tonie.png" />
  <?php else : ?>
    <link rel="shortcut icon" href="public/img/favicon.png" />
  <?php endif; ?>

  <?php if (getenv('APPLICATION_NAME')) : ?>
    <title><?php echo getenv('APPLICATION_NAME'); ?></title>
  <?php else : ?>
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
      <div class="col-md-12 col-lg-8 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">
              Instalação
            </h5>

            <div class="col-md-12">
              <?php FlashMessage::show(); ?>
            </div>

            <form class="form-signin" method="post" action="">
              <div class="form-group">
                <h5 class="text-muted text-center">Banco de dados</h5>
              </div>

              <div class="form-row">
                <div class="form-label-group col">
                  <input type="text" id="HOST_NAME" name="HOST_NAME" class="form-control" placeholder="Host" required autofocus />
                  <label for="HOST_NAME">Host</label>
                </div>

                <div class="form-label-group col">
                  <input type="text" id="HOST_USERNAME" name="HOST_USERNAME" class="form-control" placeholder="Usuário" required />
                  <label for="HOST_USERNAME">Usuário</label>
                </div>
              </div>

              <div class="form-row">
                <div class="form-label-group col">
                  <input type="password" id="HOST_PASSWORD" name="HOST_PASSWORD" class="form-control" placeholder="Senha" />
                  <label for="HOST_PASSWORD">Senha</label>
                </div>

                <div class="form-label-group col">
                  <input type="text" id="HOST_DBNAME" name="HOST_DBNAME" class="form-control" placeholder="Nome do banco" required />
                  <label for="HOST_DBNAME">Nome do banco</label>
                </div>
              </div>

              <hr class="mt-0" />

              <div class="form-group">
                <h5 class="text-muted text-center">Configurações da aplicação</h5>
              </div>

              <div class="form-row">
                <div class="form-label-group col">
                  <select name="APP_ENV" id="APP_ENV" class="form-control">
                    <option value="" selected disabled>Selecione o enviroment</option>
                    <option value="local">Local</option>
                    <option value="testing">Testes</option>
                    <option value="production">Produção</option>
                  </select>
                </div>

                <div class="form-label-group col">
                  <select name="APP_TIMEZONE" id="APP_TIMEZONE" class="form-control">
                    <option value="" selected disabled>Timezone</option>
                    <?php foreach ($timezones as $index => $timezone) { ?>
                      <option value="<?= $index ?>"><?= $timezone ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-row form-checkboxes">
                <div class="form-label-group col">
                  <label for="APP_DISPLAY_ERRORS">
                    <input type="checkbox" id="APP_DISPLAY_ERRORS" name="APP_DISPLAY_ERRORS" placeholder="Exibir erros" />
                    &nbsp;
                    Exibir erros
                  </label>
                </div>

                <div class="form-label-group col">
                  <label for="HTTPS">
                    <input type="checkbox" id="APP_HTTPS" name="APP_HTTPS" placeholder="HTTPS" />
                    &nbsp;
                    Sistema em HTTPS
                  </label>
                </div>
              </div>

              <hr class="mt-0" />

              <div class="form-group">
                <h5 class="text-muted text-center">Configurações de email</h5>
              </div>

              <div class="form-row">
                <div class="form-label-group col">
                  <input type="text" id="MAIL_HOST" name="MAIL_HOST" class="form-control" placeholder="Host" />
                  <label for="MAIL_HOST">Host</label>
                </div>

                <div class="form-label-group col">
                  <input type="text" id="MAIL_PORT" name="MAIL_PORT" class="form-control" placeholder="Porta" />
                  <label for="MAIL_PORT">Porta</label>
                </div>
              </div>

              <div class="form-row">
                <div class="form-label-group col">
                  <input type="text" id="MAIL_USERNAME" name="MAIL_USERNAME" class="form-control" placeholder="Usuário" />
                  <label for="MAIL_USERNAME">Usuário</label>
                </div>

                <div class="form-label-group col">
                  <input type="password" id="MAIL_PASSWORD" name="MAIL_PASSWORD" class="form-control" placeholder="Senha" />
                  <label for="MAIL_PASSWORD">Senha</label>
                </div>
              </div>

              <hr class="my-4">

              <div class="form-buttons">
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Salvar</button>
              </div>

              <center style="font-size:13px;opacity:0.70">ZigMoney <span style="font-size:17px">&hearts;</span></center>
            </form>
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
