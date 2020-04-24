<?php
$nomeFuncao = readline("Digite o comando: ");

function controller($nome)
{
	$arquivo = fopen("App/Controllers/{$nome}.php",'w');

$texto = "<?php
namespace App\Controllers;

class {$nome} 
{
	public function index()
	{
		# Escreva aqui...
	}
}

";

fwrite($arquivo, $texto);
//Fechamos o arquivo após escrever nele
fclose($arquivo);

if ($arquivo == false) die('Não foi possível criar o arquivo.');
}

$c = explode('.', $nomeFuncao);

if ($c[0] == "controller") {
	controller($c[1]);
}
?>