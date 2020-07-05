<!DOCTYPE html>
<html>
<head>
	<title>Zig</title>
	<meta charset="utf-8">
  <base href="<?php echo BASEURL;?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php echo BASEURL;?>/public/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASEURL;?>/public/css/login.css">
  <style type="text/css">
    body {
      background-image: url('public/img/fundo_login.jpg');
      background-repeat: no-repeat;
      background-size:100%;
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
            <?php $this->viewRender();?>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>