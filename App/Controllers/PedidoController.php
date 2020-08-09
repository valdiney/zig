<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;
use App\Rules\Logged;

use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\ClienteEndereco;
use App\Models\Produto;
use App\Models\MeioPagamento;
use App\Models\ProdutoPedido;

class PedidoController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;

  protected $idEmpresa;
  protected $idUsuarioLogado;
  protected $idPerfilUsuarioLogado;

	public function __construct()
	{
		parent::__construct();
		$this->layout = 'default';

		$this->post = new Post();
		$this->get = new Get();
    $this->idEmpresa = Session::get('idEmpresa');
    $this->idUsuarioLogado = Session::get('idUsuario');
    $this->idPerfilUsuarioLogado = session::get('idPerfil');

		$logged = new Logged();
		$logged->isValid();
	}

	public function index()
	{
    $pedido = new Pedido();
    $pedidos = $pedido->pedidos($this->idUsuarioLogado);

		$this->view('pedido/index', $this->layout, compact('pedidos'));
	}

	public function save()
	{
    if ($this->post->hasPost()) {
      $pedido = new Pedido();
      $produtoPedido = new ProdutoPedido();

      $dadosPedido = (array) $this->post->only([
        'id_vendedor', 'id_cliente', 'id_meio_pagamento',
        'id_cliente_endereco', 'valor_desconto', 'valor_frete',
        'previsao_entrega', 'total'
      ]);

      $dadosPedido['valor_desconto'] = formataValorMoedaParaGravacao($dadosPedido['valor_desconto']);
      $dadosPedido['valor_frete'] = formataValorMoedaParaGravacao($dadosPedido['valor_frete']);
      $dadosPedido['previsao_entrega'] = date('Y-m-d', strtotime($dadosPedido['previsao_entrega']));
      $dadosPedido['id_empresa'] = $this->idEmpresa;
      $dadosPedido['id_situacao_pedido'] = 1;

      /**
      * Calcula o valor total do pedido levendo-se em concideração
      * o valor do desconto e valor do frete
      */
      $dadosPedido['total'] = $pedido->valorTotalDoPedido($dadosPedido);

      try {
				$pedido->save($dadosPedido);

			} catch(\Exception $e) {
    		dd($e->getMessage());
      }

      try {
        foreach ($_POST['idDosProdutos'] as $id) {
          $produtoPedido = new ProdutoPedido();
          $produto = $produtoPedido->produtosAdicionadosPorIdProdutoEIdVendedor($id, $this->idPerfilUsuarioLogado);

          $dados['id_pedido'] = $pedido->lastId();
          $dados['id_produto'] = $produto['id'];
          $dados['preco'] = $produto['preco'];
          $dados['quantidade'] = $produto['quantidade'];
          $dados['subtotal'] = $produto['subTotal'];

          $produtoPedido->save($dados);
        }

        echo json_encode(['status' => true]);
        unset($_SESSION['itensPedido']);

      } catch(\Exception $e) {
        echo json_encode(['status' => false]);
        unset($_SESSION['itensPedido']);
    		dd($e->getMessage());
      }
    }
  }

	public function update()
	{
		# Escreva aqui...
	}

  public function modalFormulario($idPedido = false)
  {
    $pedido = false;

    if ($idPedido) {
      $produto = new Pedido();
      $pedido = $pedido->find($idPedido);
    }

    $usuario = new Usuario();
    $usuario = $usuario->find($this->idUsuarioLogado);

    $cliente = new Cliente();
    $clientes = $cliente->clientes($this->idEmpresa);

    $produto = new Produto();
    $produtos = $produto->produtos($this->idEmpresa);

    $meioPagamento = new MeioPagamento();
    $meiosPagamentos = $meioPagamento->all();

    $this->view('pedido/formulario', null,
      compact(
        'pedido',
        'usuario',
        'clientes',
        'produtos',
        'meiosPagamentos'
      ));
  }

  public function enderecoPorIdCliente($idCliente)
  {
    $clienteEndereco = new ClienteEndereco();
    echo json_encode($clienteEndereco->enderecos($idCliente));
  }

  public function produtoPorId($idProduto, $quantidade)
  {
    $produto = new Produto();
    $produto = $produto->find($idProduto);

    # Adiciona Produto na sessao
    $produtoPedido = new ProdutoPedido();
    $produtoPedido->adicionarProdutoNoPedido(
      $produto,
      $quantidade,
      $this->idPerfilUsuarioLogado
    );

    # Retorna o Produto Adicionado
    echo json_encode($produtoPedido->retornaProdutoAdicionado($this->idPerfilUsuarioLogado));
  }

  public function retirarProdutoDoPedido($idProduto)
  {
    $produto = new Produto();
    $produto = $produto->find($idProduto);

    $produtoPedido = new ProdutoPedido();
    $retirado = $produtoPedido->retirarProdutoDoPedido($produto, $this->idPerfilUsuarioLogado);

    if ($retirado) {
      echo json_encode(["status" => true]);
    } else {
      echo json_encode(["status" => false]);
    }
  }

  public function teste()
  {
    #unset($_SESSION['itensPedido']);
    dd($_SESSION['itensPedido']);
  }
}

