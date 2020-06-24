<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;
use App\Rules\Logged;

use App\Models\Modulo;
use App\Models\UsuarioModulo;

class UsuarioModuloController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;
	protected $idEmpresa;

	public function __construct()
	{
		parent::__construct();
		$this->layout = 'default';

		$this->post = new Post();
		$this->get = new Get();
		$this->idEmpresa = Session::get('idEmpresa');

		$logged = new Logged();
		$logged->isValid();
	}

	public function index()
	{
		$idUsuario = out64($this->get->position(0));

        $usuarioModulo = new UsuarioModulo();
        $usuarioModulos = $usuarioModulo->usuariosModulosPorIdEmpresaEIdUsuario(
        	$this->idEmpresa, 
        	$idUsuario
        );

		$this->view('usuario/permissoes', $this->layout, compact('usuarioModulos'));
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

