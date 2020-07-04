<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;
use App\Rules\Logged;

use App\Models\Modulo;
use App\Models\UsuarioModulo;
use App\Models\Usuario;

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
		$usuario = new Usuario();
        $usuario = $usuario->find($idUsuario);

        $usuarioModulo = new UsuarioModulo();
        $usuarioModulos = $usuarioModulo->usuariosModulosPorIdEmpresaEIdUsuario(
        	$this->idEmpresa, 
        	$idUsuario,
        	$usuario->id_perfil
        );

		$this->view('usuario/permissoes', $this->layout, 
			compact(
				'usuarioModulos',
				'usuario'
			));
	}

	public function salvarPermissoes()
	{
		$idUsuario = $this->get->position(0);
		$idModulo = $this->get->position(1);
		$tipoPermissao = $this->get->position(2);

		$usuarioModulo = new UsuarioModulo();
		
		if ($usuarioModulo->salvarPermissoes($idUsuario, $idModulo, $tipoPermissao)) {
			echo json_encode(['status' => true]);
		} else {
			echo json_encode(['status' => false]);
		}
	}
}