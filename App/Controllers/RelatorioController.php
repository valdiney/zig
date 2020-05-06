<?php 
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

use App\Models\Venda;
use App\Models\Usuario;
use App\Models\MeioPagamento;

class RelatorioController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;
	protected $idCliente;
	protected $idPerfilUsuarioLogado;
	
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
		$this->view('relatorio/index', $this->layout); 	
	}
}