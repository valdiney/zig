<?php 
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

use App\Repositories\VendasRepository;

class HomeController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;
	protected $vendasRepository;
	protected $idEmpresa;
	protected $idUsuario;
	protected $idPerfilUsuarioLogado;
	
	public function __construct()
	{
		parent::__construct();
		$this->layout = 'default';

		$this->post = new Post();
		$this->get = new Get();

		$this->idEmpresa = Session::get('idEmpresa');
		$this->idUsuario = Session::get('idUsuario');
		$this->idPerfilUsuarioLogado = Session::get('idPerfil');
	}

	public function index()
	{
		$vendasRepository = new VendasRepository();

        $faturamentoDeVandasNoMes = $vendasRepository->faturamentoDeVendasNoMes(
            date('m'), date('Y'), $this->idEmpresa
        );

        $faturamentoDeVandasNoDia = $vendasRepository->faturamentoDeVendasNoDia(
        	date('d'), date('m'), $this->idEmpresa
        );

        $faturamentoDeVandasMesAnterior = $vendasRepository->faturamentoDeVendasNoMes(
        	decrementMonthtFromDate(1), date('Y'), $this->idEmpresa
        );

        $faturamentoDeVandasNoDiaAnterior = $vendasRepository->faturamentoDeVendasNoDia(
            date('d', strtotime(decrementDaysFromDate(1))), date('m'), $this->idEmpresa
        );

		$this->view('home/index', $this->layout, 
			compact(
				'faturamentoDeVandasNoMes',
				'faturamentoDeVandasNoDia',
				'faturamentoDeVandasMesAnterior',
				'faturamentoDeVandasNoDiaAnterior'
			));
	}
}