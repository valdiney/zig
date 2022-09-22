<?php

namespace App\Controllers\Api;

use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use App\Repositories\RelatorioVendasPorPeriodoRepository;

class RelatorioController extends Controller
{
    protected $post;
    protected $get;

    public function __construct()
    {
        parent::__construct();

        $this->post = new Post();
        $this->get = new Get();
    }

    public function vendas($idEmpresa)
    {
        $relatorioVendas = new RelatorioVendasPorPeriodoRepository();
        $periodoDisponivelParaConsulta = $relatorioVendas->periodoDisponivelParaConsulta($idEmpresa);

        $agrupamentoDeVendas = $relatorioVendas->agrupamentoDeVendasPorPeriodo(
            ['de' => dateFormat($periodoDisponivelParaConsulta->primeiraVenda),
            'ate' => dateFormat($periodoDisponivelParaConsulta->ultimaVenda)],
            false,
            $idEmpresa
        );

        $dados = [];

        $dados['pelatorio']['periodosDisponiveis'] = $periodoDisponivelParaConsulta;
        $dados['vendas'] = $agrupamentoDeVendas;

        echo json_encode($dados);

    }
}
