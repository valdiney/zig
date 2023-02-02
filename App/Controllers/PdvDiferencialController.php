<?php

namespace App\Controllers;

use App\Models\MeioPagamento;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\AgrupadorVenda;
use App\Repositories\VendasEmSessaoRepository;
use App\Rules\AcessoAoTipoDePdv;
use App\Rules\Logged;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;

class PdvDiferencialController extends Controller
{
    protected $post;
    protected $get;
    protected $layout;
    protected $idEmpresa;
    protected $idUsuario;
    protected $idPerfilUsuarioLogado;
    protected $vendasEmSessaoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'default';

        $this->post = new Post();
        $this->get = new Get();
        $this->idEmpresa = Session::get('idEmpresa');
        $this->idUsuario = Session::get('idUsuario');
        $this->idPerfilUsuarioLogado = Session::get('idPerfil');

        $this->vendasEmSessaoRepository = new VendasEmSessaoRepository();

        $logged = new Logged();
        $logged->isValid();

        $acessoAoTipoDePdv = new AcessoAoTipoDePdv();
        $acessoAoTipoDePdv->validate();
    }

    public function index()
    {
        $meioPagamento = new MeioPagamento();
        $meiosPagamentos = $meioPagamento->all();

        $produto = new Produto();
        $produtos = $produto->produtosNoPdv($this->idEmpresa);

        $this->view('pdv/diferencial', $this->layout,
            compact(
                'meiosPagamentos',
                'produtos'
            ));
    }

    public function saveVendasViaSession()
    {
        if (!isset($_SESSION['venda']) ||empty($_SESSION['venda'])) {
            return;
        }

        $status = false;
        $meioDePagamento = $this->post->data()->id_meio_pagamento;
        $dataCompensacao = '0000-00-00';

        # só adiciona caso seja um boleto
        if ($meioDePagamento == 4) {
            $dataCompensacao = $this->post->data()->data_compensacao;
        }

        /**
         * Gera um código unico de venda que será usado em todos os registros desse Loop
        */
        $codigoVenda = uniqid(rand(), true).date('s').date('d.m.Y');

        $valorRecebido = formataValorMoedaParaGravacao($this->post->data()->valor_recebido);
        $troco = formataValorMoedaParaGravacao($this->post->data()->troco);

        foreach ($_SESSION['venda'] as $produto) {
            $dados = [
                'id_usuario' => $this->idUsuario,
                'id_meio_pagamento' => $meioDePagamento,
                'data_compensacao' => $dataCompensacao,
                'id_empresa' => $this->idEmpresa,
                'id_produto' => $produto['id'],
                'preco' => $produto['preco'],
                'quantidade' => $produto['quantidade'],
                'valor' => $produto['total'],
                'codigo_venda' => $codigoVenda
            ];

            if ( ! empty($valorRecebido) && ! empty($troco)) {
                $dados['valor_recebido'] = $valorRecebido;
                $dados['troco'] = $troco;
            }

            $venda = new Venda();
            try {
                $venda = $venda->save($dados);
                $status = true;

                $produto = new Produto();
                $produto->decrementaQuantidadeProduto((int) $dados['id_produto'], (int) $dados['quantidade']);

                unset($_SESSION['venda']);

            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        echo json_encode(['status' => $status]);
    }

    public function colocarProdutosNaMesa($idProduto)
    {
        return $this->vendasEmSessaoRepository->colocarProdutosNaMesa($idProduto);
    }

    public function obterProdutosDaMesa($posicaoProduto)
    {
        echo $this->vendasEmSessaoRepository->obterProdutosDaMesa($posicaoProduto);
    }

    public function alterarAquantidadeDeUmProdutoNaMesa($idProduto, $quantidade)
    {
        $produto = new Produto();
        $dadosProduto = $produto->find($idProduto);

        if ($dadosProduto->ativar_quantidade && $quantidade > $dadosProduto->quantidade) {
            echo json_encode(['quantidade_insuficiente' => true, 'unidades' => $dadosProduto->quantidade]);
            return false;
        }

        $this->vendasEmSessaoRepository->alterarAquantidadeDeUmProdutoNaMesa($idProduto, $quantidade);
        echo json_encode(['quantidade_insuficiente' => false]);
    }

    public function retirarProdutoDaMesa($idProduto)
    {
        $this->vendasEmSessaoRepository->retirarProdutoDaMesa($idProduto);
    }

    public function obterValorTotalDosProdutosNaMesa()
    {
        echo $this->vendasEmSessaoRepository->obterValorTotalDosProdutosNaMesa();
    }

    public function calcularTroco($valorRecebido)
    {
        $valorRecebido = out64($valorRecebido);
        $valorRecebido = explode('R$', $valorRecebido);
        if (array_key_exists(1, $valorRecebido)) {
            $valor = $valorRecebido[1];
        } else {
            $valor = $valorRecebido[0];
        }

        echo $this->vendasEmSessaoRepository->calcularTroco(formataValorMoedaParaGravacao($valor));
    }

    public function pesquisarProdutoPorNome($nome = false)
    {
        $nome = utf8_encode(out64($nome));

        $produto = new Produto();
        $produtos = $produto->produtosNoPdv($this->idEmpresa, $nome);

        $this->view('pdv/produtosAvenda', null, compact('produtos'));
    }

    public function pesquisarProdutoPorCodeDeBarra($codigo = false)
    {
        $codigo = utf8_encode(out64($codigo));

        $produto = new Produto();
        $produtos = $produto->produtosNoPdvFiltrarPorCodigoDeBarra($this->idEmpresa, $codigo);

        $this->view('pdv/produtosAvenda', null, compact('produtos'));
    }
}
