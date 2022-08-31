<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Models\Produto;
use App\Repositories\VendasRepository;
use App\Rules\Logged;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;

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

        $logged = new Logged();
        $logged->isValid();
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

        $mesAnterior = decrementMonthtFromDate(1);
        $ano = date('Y');
        /** Se o mês anterior for igual a 12, significa que foi ano passado
         * então passa o ano anterior para ser buscado na query os dados de Dezembro do ano passado
         */
        if ($mesAnterior == '12') {
            $ano = date('Y', strtotime('-1 years'));
        }

        $faturamentoDeVandasMesAnterior = $vendasRepository->faturamentoDeVendasNoMes(
            decrementMonthtFromDate(1), $ano, $this->idEmpresa
        );

        $faturamentoDeVandasNoDiaAnterior = $vendasRepository->faturamentoDeVendasNoDia(
            date('d', strtotime(decrementDaysFromDate(1))), date('m'), $this->idEmpresa
        );

        $percentualMeiosDePagamento = $vendasRepository->percentualMeiosDePagamento($this->idEmpresa);

        $quantidadeDeVendasRealizadasPorDia = $vendasRepository->quantidadeDeVendasRealizadasPorDia(
            [], $this->idEmpresa
        );

        $valorDeVendasRealizadasPorDia = $vendasRepository->valorDeVendasRealizadasPorDia(
            [], $this->idEmpresa
        );

        $totalVendasPorUsuariosNoMes = $vendasRepository->totalVendasPorUsuariosNoMes($this->idEmpresa, date('m'));

        $cliente = new Cliente();
        $clientesCadastrados = $cliente->quantidadeDeClientesCadastrados($this->idEmpresa);

        $produto = new Produto();
        $produtosCadastrados = $produto->quantidadeDeProdutosCadastrados($this->idEmpresa);

        $produtosMaisVendidosNoMes = $vendasRepository->produtosMaisVendidosNoMes($this->idEmpresa, date('m'), 6);

        $vendasPorMesNoAno = $vendasRepository->vendasPorMesNoAno($this->idEmpresa);

        $this->view('home/index', $this->layout,
            compact(
                'faturamentoDeVandasNoMes',
                'faturamentoDeVandasNoDia',
                'faturamentoDeVandasMesAnterior',
                'faturamentoDeVandasNoDiaAnterior',
                'percentualMeiosDePagamento',
                'quantidadeDeVendasRealizadasPorDia',
                'valorDeVendasRealizadasPorDia',
                'totalVendasPorUsuariosNoMes',
                'clientesCadastrados',
                'produtosCadastrados',
                'produtosMaisVendidosNoMes',
                'vendasPorMesNoAno'
            ));
    }
}
