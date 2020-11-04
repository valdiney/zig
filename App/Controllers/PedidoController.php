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

use App\Repositories\VendasEmSessaoRepository;

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

class PedidoController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;

  protected $idEmpresa;
  protected $idUsuarioLogado;
  protected $idPerfilUsuarioLogado;
  protected $vendasEmSessaoRepository;

	public function __construct()
	{
		parent::__construct();
		$this->layout = 'default';

		$this->post = new Post();
		$this->get = new Get();
    $this->idEmpresa = Session::get('idEmpresa');
    $this->idUsuarioLogado = Session::get('idUsuario');
    $this->idPerfilUsuarioLogado = session::get('idPerfil');

    $this->vendasEmSessaoRepository = new VendasEmSessaoRepository();

		$logged = new Logged();
		$logged->isValid();
	}

	public function index()
	{
    $pedido = new Pedido();
    $pedidos = $pedido->pedidos($this->idUsuarioLogado);

		$this->view('pedido/index', $this->layout, compact('pedidos'));
  }

  public function salvarPrimeiroPasso()
  {
    if ($this->post->hasPost()) {
      $pedido = new Pedido();
      $produtoPedido = new ProdutoPedido();

      # 7: Imcompleto
      $idSituacaoPedido = 7;
      $dadosPedido = (array) $this->post->only([
        'id_cliente', 'id_cliente_endereco'
      ]);

      $dadosPedido['id_vendedor'] = $this->idUsuarioLogado;

      try {
        $pedido->save($dadosPedido);
        echo json_encode(['status' => true, 'id_pedido' => $pedido->lastId()]);

      } catch(\Exception $e) {
        echo json_encode(['status' => false]);
        dd($e->getMessage());
      }
    }
  }

  public function adicionarProduto()
  {
    if ($this->post->hasPost()) {
      $dadosDoFormulrio =  $this->post->data();

      $produtoPedido = new ProdutoPedido();
      $produto = new Produto();
      $produto = $produto->find($dadosDoFormulrio->id_produto);

      $dadosPedido = [
        'id_pedido' => $dadosDoFormulrio->id_pedido,
        'id_produto' => $produto->id,
        'preco' => $produto->preco,
        'quantidade' => $dadosDoFormulrio->quantidade,
        'subtotal' => $produto->preco * $dadosDoFormulrio->quantidade
      ];

      try {
        $produtoPedido->save($dadosPedido);
        echo json_encode([
          'status' => true,
          'produto' => $produtoPedido->produtoPorIdProdutoPedido($produtoPedido->lastId())
        ]);

      } catch(\Exception $e) {
        echo json_encode(['status' => false]);
        dd($e->getMessage());
      }

      # Atualiza o valor do total na tabela de pedidos
      $pedido = new Pedido();
      $pedido->update(
        ['total' => $produtoPedido->valorTotalDoPedido($dadosDoFormulrio->id_pedido)->total],
        $dadosDoFormulrio->id_pedido
      );
    }
  }

  public function finalizarPedido()
  {
    $pedido = new Pedido();
    $produtoPedido = new ProdutoPedido();
    $dadosPedido = (array) $this->post->only([
      'id_meio_pagamento', 'valor_desconto',
      'valor_frete', 'previsao_entrega'
    ]);

    if ($this->post->hasPost()) {
      try {
        $pedido->update($dadosPedido, $this->post->data()->id_pedido);
        echo json_encode(['status' => true]);

      } catch(\Exception $e) {
        echo json_encode(['status' => false]);
        dd($e->getMessage());
     }
    }
  }

  public function teste()
  {
    $produtoPedido = new ProdutoPedido();
    $a = $produtoPedido->valorTotalDoPedido(107)->total;
    dd($a);
  }

  public function excluirProdutoPedido($idProdutoPedido)
  {
    $produtoPedido = new ProdutoPedido();
    try {
      $produtoPedido->excluirProdutoPedido($idProdutoPedido);
      echo json_encode(['status' => true]);

    } catch(\Exception $e) {
      echo json_encode(['status' => false]);
    }
  }

  public function alterarQuantidadeProdutoPedido()
  {
    $produtoPedido = new ProdutoPedido();
    try {
      $produtoPedido->alterarQuantidadeProdutoPedido(
        $this->post->data()->idProdutoPedido,
        $this->post->data()->quantidade
      );

      echo json_encode(['status' => true]);

    } catch(\Exception $e) {
      echo json_encode(['status' => false]);
    }
  }

  public function produtosPorIdPedido($idPedido)
  {
    $produtoPedido = new ProdutoPedido();
    echo json_encode($produtoPedido->produtosPorIdPedido($idPedido));
  }

  public function modalFormulario($idPedido = false)
  {
    $pedido = false;
    $idClienteEnderecoPedido = false;

    #dd($idPedido);

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
        'idPedido',
        'pedido',
        'usuario',
        'clientes',
        'produtos',
        'meiosPagamentos',
        'idClienteEnderecoPedido'
      ));
  }

  public function enderecoPorIdCliente($idCliente)
  {
    $clienteEndereco = new ClienteEndereco();
    echo json_encode($clienteEndereco->enderecos($idCliente));
  }
}

