<?php 
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

use App\Models\Venda;
use App\Models\Usuario;
use App\Models\MeioPagamento;

use App\Repositories\RelatorioVendasPorPeriodoRepository;

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

	public function vendasPorPeriodo()
	{
		$usuario = new Usuario();
		$usuarios = $usuario->usuarios($this->idCliente, $this->idPerfilUsuarioLogado);

		$this->view('relatorio/vendasPorPeriodo/index', $this->layout, compact('usuarios'));
	}

	public function vendasChamadaAjax()
	{
		$relatorioVendas = new RelatorioVendasPorPeriodoRepository();
		$vendas = [];

		if ($this->post->hasPost()) {

			$de = $this->post->data()->de;
			$ate = $this->post->data()->ate;

			$idUsuario = false;
			if ($this->post->data()->id_usuario != 'todos') {
				$idUsuario = $this->post->data()->id_usuario;
			}

			$vendas = $relatorioVendas->vendasPorPeriodo(
				['de' => $de, 'ate' => $ate], 
				$idUsuario,
				$this->idCliente
		     );

			$meiosDePagamento = $relatorioVendas->totalVendidoPorMeioDePagamento(
				['de' => $de, 'ate' => $ate], 
				$idUsuario,
				$this->idCliente
			);

			$totalDasVendas = $relatorioVendas->totalDasVendas(
				['de' => $de, 'ate' => $ate], 
				$idUsuario,
				$this->idCliente
			);
		}

		$this->view('relatorio/vendasPorPeriodo/tabelaVendasPorPeriodo', false, 
			compact(
				'vendas',
				'meiosDePagamento',
				'totalDasVendas'
			));
	}
}