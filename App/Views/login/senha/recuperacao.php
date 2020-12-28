<!--Usando o Html Components-->
<?php

use System\HtmlComponents\FlashMessage\FlashMessage; ?>

<form class="form-signin" method="post" action="<?php echo BASEURL . "/login/senha/recuperacao/{$hash}"; ?>">

    <h3 class="form-subtitle">Digite uma nova senha!</h3>

    <div class="">
        <?php FlashMessage::show(); ?>
    </div>

    <!-- token de segurança -->
    <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

    <div class="form-label-group">
        <input type="password" id="password" name="password" class="form-control" placeholder="Sua nova senha" required
               autofocus>
        <label for="password">Nova senha</label>
    </div>

    <div class="form-label-group">
        <input type="password" id="password_check" name="password_check" class="form-control"
               placeholder="Repita a senha" required>
        <label for="password_check">Repita a senha</label>
    </div>

    <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Alterar</button>

    <div class="form-links">
        <a href="<?php echo BASEURL; ?>/login">Fazer login ao invés disso?</a>
    </div>

    <hr class="my-4">

    <center style="font-size:13px;opacity:0.70">ZigMoney <span style="font-size:17px">&hearts;</span></center>

</form>
