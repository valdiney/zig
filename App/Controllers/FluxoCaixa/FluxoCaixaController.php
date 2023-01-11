<?php
namespace App\Controllers\FluxoCaixa;

use App\Rules\Logged;
use Exception;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;
use App\Models\FluxoCaixa;

class FluxoCaixaController extends Controller
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
        $this->view('fluxoDeCaixa/index', $this->layout);
    }

    # Renderiza a grid do fluxo de caixa. Chamada via ajax
    public function tabelaFluxoDeCaixa()
    {
        $periodo = [
            'de' => $this->post->data()->de,
            'ate' => $this->post->data()->ate
        ];

        $tipoPeriodo = isset($this->post->data()->tipo_periodo) ? $this->post->data()->tipo_periodo : false;

        $fluxoCaixa = new FluxoCaixa();
        $fluxoCaixa->setRetirarPDV(is_null($this->post->data()->retirarPDV) ? false : true);
        $retirarPDV = $fluxoCaixa->getRetirarPDV();

        $fluxo = $fluxoCaixa->fluxoDeCaixa($periodo, $this->idEmpresa);
        $fluxoDetalhadoPorMes = $fluxoCaixa->fluxoDeCaixaDetalhadoPorMes($periodo, $tipoPeriodo, $this->idEmpresa);

        $this->view('fluxoDeCaixa/tabelaFluxoDeCaixa', false,
        compact(
            'fluxo',
            'fluxoDetalhadoPorMes',
            'retirarPDV'
        ));
    }

    public function modalRegistrarMovimentacao($idFluxo = false)
    {
        $fluxoCaixa = false;

        if ($idFluxo) {
            $fluxoCaixa = new FluxoCaixa();
            $fluxoCaixa = $fluxoCaixa->find($idFluxo);
        }

        $this->view('fluxoDeCaixa/formulario_movimentacao', null, compact('fluxoCaixa'));
    }

    public function save()
    {
        $fluxoCaixa = new FluxoCaixa();
        $dados = (array) $this->post->data();
        $dados['id_empresa'] = $this->idEmpresa;
        $dados['data'] = date('Y-m-d H:i:s', strtotime($dados['data']));
        $dados['valor'] = formataValorMoedaParaGravacao($dados['valor']);
        $dados['tipo_movimento'] = (is_null($dados['tipo_movimento'])) ? 0 : $dados['tipo_movimento'];

        try {
            $fluxoCaixa->save($dados);
            return $this->get->redirectTo("fluxoDeCaixa/index");

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update()
    {
        $fluxoCaixa = new FluxoCaixa();
        $dados = (array) $this->post->data();
        $dados['id_empresa'] = $this->idEmpresa;
        $dados['data'] = date('Y-m-d H:i:s', strtotime($dados['data']));
        $dados['valor'] = formataValorMoedaParaGravacao($dados['valor']);
        $dados['tipo_movimento'] = (is_null($dados['tipo_movimento'])) ? 0 : $dados['tipo_movimento'];

        try {
            $fluxoCaixa->update($dados, $this->post->data()->id);
            return $this->get->redirectTo("fluxoDeCaixa/index");

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
