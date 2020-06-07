<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

use App\Models\ConfigPdv;
use App\Models\Venda;
use App\Models\Usuario;
use App\Models\MeioPagamento;
use App\Models\Produto;
use App\Rules\Logged;

use App\Rules\AcessoAoTipoDePdv;

class PdvDiferencialController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;
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

		$acessoAoTipoDePdv = new AcessoAoTipoDePdv();
		$acessoAoTipoDePdv->validate();

		$logged = new Logged();
		$logged->isValid();
	}

	public function index()
	{
		$meioPagamanto = new MeioPagamento();
		$meiosPagamentos = $meioPagamanto->all();

		$produto = new Produto();
		$produtos = $produto->produtos($this->idEmpresa);

		$this->view('pdv/diferencial', $this->layout, 
			compact(
				'meiosPagamentos',
				'produtos'
			));
	}

	public function saveVendasViaSession()
	{
		$status = false;
		foreach ($_SESSION['venda'] as $produto) {
			$dados = [
				'id_usuario' => $this->idUsuario,
				'id_meio_pagamento' => $this->post->data()->id_meio_pagamento,
				'id_empresa' => $this->idEmpresa,
				'id_produto' => $produto['id'],
				'preco' => $produto['preco'],
				'quantidade' => $produto['quantidade'],
				'valor' => $produto['total']
			];

			$venda = new Venda();
			try {
		        $venda->save($dados);
		        $status = true;

		        unset($_SESSION['venda']);

		    } catch(\Exception $e) { 
			    dd($e->getMessage());
		    }
		}
        
		echo json_encode(['status' => $status]);
	}

	public function colocarProdutosNaMesa()
	{
		if ($this->get->position(0)) {
			$id = $this->get->position(0);

			if ( ! isset($_SESSION['venda'])) {
				$_SESSION['venda'] = [];
			} 

			if ( ! isset($_SESSION['venda'][$id])) {

				$produto = new Produto();
				$produto = $produto->find($id);

				$_SESSION['venda'][$id] = [
					'id' => $id, 
					'produto' => $produto->nome,
					'preco' => $produto->preco,
					'imagem' => $produto->imagem,
					'quantidade' => 1,
					'total' => $produto->preco
				];
			}	
		}

		echo json_encode($_SESSION['venda']);
	}

	public function obterProdutosDaMesa()
	{
		$posicaoProduto = $this->get->position(0);
		if (isset($_SESSION['venda'])) {
			if ($posicaoProduto == 'ultimo') {
				echo json_encode(end($_SESSION['venda']));
			} else {
				echo json_encode($_SESSION['venda']);
			}
		} else {
			echo json_encode([]);
		}
	}

	public function alterarAquantidadeDeUmProdutoNaMesa()
	{
		$id = $this->get->position(0);
		$quantidade = $this->get->position(1);

		if (isset($_SESSION['venda'])) {
			$_SESSION['venda'][$id]['quantidade'] = $quantidade;
			$_SESSION['venda'][$id]['total'] = $quantidade * $_SESSION['venda'][$id]['preco'];
		} 
	}

	public function retirarProdutoDaMesa()
	{
		$id = $this->get->position(0);

		if (isset($_SESSION['venda'])) {
			unset($_SESSION['venda'][$id]);
		}
	}

	public function obterValorTotalDosProdutosNaMesa()
	{
		$total = 0;
		if (isset($_SESSION['venda'])) {
		    foreach($_SESSION['venda'] as $produto) {
		        $total += $produto['total'];
		    }
		}
	    
        echo json_encode(['total' => $total]);
	}
}