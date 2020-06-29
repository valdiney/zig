<style>
  body, .container, .row {
    min-height: 100vh;
  }
  .container .row > div {
    margin: auto !important;
  }
</style>

<div class="col-md-12">
	<?php require_once('../App/Views/Layouts/HtmlComponents/FlashMessage.php');?>
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

</form>