<?php 
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;
use App\Rules\Logged;

use App\Models\Venda;
use App\Models\Usuario;
use App\Models\MeioPagamento;

use App\Repositories\RelatorioVendasPorPeriodoRepository;

class RelatorioController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;
	protected $idEmpresa;
	protected $idPerfilUsuarioLogado;
	
	public function __construct()
	{
		parent::__construct();
		$this->layout = 'default';

		$this->post = new Post();
		$this->get = new Get();
		$this->idEmpresa = Session::get('idEmpresa');
		$this->idPerfilUsuarioLogado = Session::get('idPerfil');

		$logged = new Logged();
		$logged->isValid();
	}

	public function index()
	{
		$this->view('relatorio/index', $this->layout); 	
	}

	public function vendasPorPeriodo()
	{
		$usuario = new Usuario();
		$usuarios = $usuario->usuarios($this->idEmpresa, $this->idPerfilUsuarioLogado);

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
				$this->idEmpresa
		    );

			$meiosDePagamento = $relatorioVendas->totalVendidoPorMeioDePagamento(
				['de' => $de, 'ate' => $ate], 
				$idUsuario,
				$this->idEmpresa
			);

			$totalDasVendas = $relatorioVendas->totalDasVendas(
				['de' => $de, 'ate' => $ate], 
				$idUsuario,
				$this->idEmpresa
			);
		}

		$this->view('relatorio/vendasPorPeriodo/tabelaVendasPorPeriodo', false, 
			compact(
				'vendas',
				'meiosDePagamento',
				'totalDasVendas'
			));
	}

	public function gerarXls()
	{

		/*
		$arquivo = "teste.xls";

		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="5">Planilha Mensagem de Contatos</tr>';
		$html .= '</tr>';
		
		
		$html .= '<tr>';
		$html .= '<td><b>ID</b></td>';
		$html .= '<td><b>Nome</b></td>';
		$html .= '<td><b>E-mail</b></td>';
		$html .= '<td><b>Assunto</b></td>';
		$html .= '<td><b>Data</b></td>';
		$html .= '</tr>';

		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		*/

        $idUsuario = false;
        $relatorioVendas = new RelatorioVendasPorPeriodoRepository();
        $periodo = ['de' => '2020-05-01', 'ate' => '2020-06-11'];
		$relatorioVendas->gerarRelatioDeVendasPorPeriodoXls($periodo, $idUsuario, $this->idEmpresa);


	}
}