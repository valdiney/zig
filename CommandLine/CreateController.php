<?php

function controller($nome) {
	$arquivo = fopen("App/Controllers/{$nome}.php",'w');
	$diretive = '$this->';
	$vars = '$';

$texto = "<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

class {$nome} extends Controller
{
	protected {$vars}post;
	protected {$vars}get;
	protected {$vars}layout;

	public function __construct()
	{
		parent::__construct();
		{$diretive}layout = 'default';

		{$diretive}post = new Post();
		{$diretive}get = new Get();
	}

	public function index()
	{
		{$diretive}view('login/index', {$diretive}layout);
	}

	public function save()
	{
		# Escreva aqui...
	}

	public function update()
	{
		# Escreva aqui...
	}
}

";

   fwrite($arquivo, $texto);
   fclose($arquivo);

	if ($arquivo) {
		return true;
	} else {
		return false;
	}
}
?>