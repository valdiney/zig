<!--Usando o Html Components-->
<?php use System\HtmlComponents\FlashMessage\FlashMessage;?>

<style>
  body, .container, .row {
    min-height: 100vh;
  }
  .container .row > div {
    margin: auto !important;
  }
</style>

<div class="col-md-12">
	<?php FlashMessage::show();?>
</div>

 <form class="form-signin" method="post" action="<?php echo BASEURL;?>/login/logar">
  <div class="form-label-group">
    <input type="email" id="email" name="email" class="form-control" placeholder="Email address"
    required autofocus>
    <label for="email">Email</label>
  </div>

  <div class="form-label-group">
    <input type="password" id="password" name="password" class="form-control" placeholder="password" required>
    <label for="password">Senha</label>
  </div>

  <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Entrar</button>
  <hr class="my-4">


  <center style="font-size:13px;opacity:0.70">ZigMoney <span style="font-size:17px">&hearts;</span></center>

</form>
