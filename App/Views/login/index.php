<!--Usando o Html Components-->
<?php

use System\HtmlComponents\FlashMessage\FlashMessage; ?>

<div class="col-md-12">
    <?php FlashMessage::show(); ?>
</div>

<form class="form-signin" method="post" action="<?php echo BASEURL; ?>/login/logar">

    <!-- token de segurança -->
    <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

    <div class="form-label-group">
        <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
        <label for="email">Email</label>
    </div>

    <div class="form-label-group">
        <input type="password" id="password" name="password" class="form-control" placeholder="password" required>
        <label for="password">Senha</label>
    </div>

    <div class="p-2">
        <label for="remember" class="checkbox-options">
            <input type="checkbox" name="remember" id="remember" checked/>
            Permanecer conectado
        </label>
    </div>

    <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Entrar</button>

    <div class="form-links">
        <a href="<?php echo BASEURL; ?>/login/senha">Esqueci a minha senha</a>
    </div>

    <!--
    <hr class="my-4">

    <center>
        <small style="opacity:0.60;">Que tal criar uma conta agora mesmo?</small><br><br>
        <a href="<?php echo BASEURL;?>/criarConta/index" class="btn btn-lg btn-secondary btn-block text-uppercase" style="color:white">Criar conta</a>
    </center>-->

    <hr class="my-4">

    <center style="font-size:13px;opacity:0.70">ZigMoney <span style="font-size:17px">&hearts;</span></center>

</form>
