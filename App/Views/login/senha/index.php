<!--Usando o Html Components-->
<?php

use System\HtmlComponents\FlashMessage\FlashMessage; ?>

<form class="form-signin" method="post" action="<?php echo BASEURL; ?>/login/senha">

  <h3 class="form-subtitle">Por favor, digite o email para o qual deseja recuperar a senha.</h3>

  <div class="">
    <?php FlashMessage::show(); ?>
  </div>

  <!-- token de segurança -->
  <input type="hidden" name="_token" value="<?php echo TOKEN; ?>" />

  <div class="form-label-group">
    <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
    <label for="email">Email</label>
  </div>

  <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Enviar link</button>

  <div class="form-links">
    <a href="<?php echo BASEURL; ?>/login">Fazer login ao invés disso?</a>
  </div>

  <hr class="my-4">

  <center style="font-size:13px;opacity:0.70">ZigMoney <span style="font-size:17px">&hearts;</span></center>

</form>
