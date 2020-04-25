<?php 
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

use App\Models\Venda;
use App\Models\Usuario;

class VendaController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;
	protected $idCliente;
	protected $sidPerfilUsuarioLogado;
	
	public function __construct()
	{
		parent::__construct();
		$this->layout = 'default';

		$this->post = new Post();
		$this->get = new Get();
		$this->idCliente = Session::get('idCliente');
		$this->idPerfilUsuarioLogado = Session::get('idPerfil');
	}

	public function index()
	{
		$venda = new Venda();
		$vendas = false;

		$usuario = new Usuario();
		$usuarios = $usuario->usuarios($this->idCliente, $this->idPerfilUsuarioLogado);

		$this->view('venda/index', $this->layout, 
			compact(
				'vendas', 
				'usuarios'
			));
	}

	public function save()
	{
		
	}

	public function update()
	{
		
	}
}