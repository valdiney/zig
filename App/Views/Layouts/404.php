<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Rota Não encontrada!</title>
	<style type="text/css">
		body {
			margin:0;
			padding:0;
			background:#f7f7f7;
			font-family:arial;
		}
		h1 {
			text-align:center;
			margin:0;
			padding:10px;
		}
		span {
			font-size:100px;
			margin-top:50px;
			display:block;
		}
	</style>
</head>
<body>
    <center>
    	<span>404</span> <br>
    	<h1 style="opacity:0.60">Poxa! Essa rota não foi encontrada!</h1>
    	<i style="opacity:0.80;color:#cc0033">
    		<?php echo "http://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']; ?>	
    	</i>
    </center> 
</body>
</html>