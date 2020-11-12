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
use App\Models\SituacaoPedido;

use App\Repositories\VendasEmSessaoRepository;

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
    $cliente = new Cliente();
    $clientes = $cliente->clientes($this->idEmpresa);

		$this->view('pedido/index', $this->layout, compact('clientes'));
  }

  public function tabelaDepedidosChamadosViaAjax()
  {
    if ($this->post->hasPost()) {
      $pedido = new Pedido();

      $idCliente = false;
      if ($this->post->data()->id_cliente != 'todos') {
        $idCliente = $this->post->data()->id_cliente;
      }

      $pedidos = $pedido->pedidos($this->idUsuarioLogado,$idCliente);

      $situacaoPedido = new SituacaoPedido();
      $situacoesPedidos = $situacaoPedido->all();
    }

    $this->view('pedido/tabelaDePedidos', null,
    compact(
      'pedidos',
      'situacoesPedidos'
    ));
  }

  public function adicionarClienteEendereco()
  {
    if ($this->post->hasPost()) {
      $pedido = new Pedido();
      $produtoPedido = new ProdutoPedido();

      $dadosPedido = (array) $this->post->only([
        'id_cliente', 'id_cliente_endereco'
      ]);

      $dadosPedido['id_vendedor'] = $this->idUsuarioLogado;
      $dadosPedido['id_situacao_pedido'] = 7; # 7: Imcompleto
      $dadosPedido['previsao_entrega'] = null;

      try {
        $pedido->save($dadosPedido);
        echo json_encode(['status' => true, 'id_pedido' => $pedido->lastId()]);

      } catch(\Exception $e) {
        echo json_encode(['status' => false]);
        dd($e->getMessage());
      }
    }
  }

  public function alterarClienteEndereco()
  {
    if ($this->post->hasPost()) {
      $pedido = new Pedido();
      $produtoPedido = new ProdutoPedido();

      $dadosPedido = (array) $this->post->only([
        'id_cliente', 'id_cliente_endereco'
      ]);

      try {
        $pedido->update($dadosPedido, $this->post->data()->id_pedido);
        echo json_encode(['status' => true]);

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
    }
  }

  public function finalizarPedido()
  {
    $pedido = new Pedido();
    $produtoPedido = new ProdutoPedido();

    $idPedido = $this->post->data()->id_pedido;
    $dadosPedido = (array) $this->post->only([
      'id_meio_pagamento', 'valor_desconto',
      'valor_frete', 'previsao_entrega'
    ]);

    $dadosPedido['valor_desconto'] = formataValorMoedaParaGravacao($dadosPedido['valor_desconto']);
    $dadosPedido['valor_frete'] = formataValorMoedaParaGravacao($dadosPedido['valor_frete']);
    $dadosPedido['id_situacao_pedido'] = 1;

    if ($this->post->hasPost()) {
      try {
        $pedido->update($dadosPedido, $idPedido);
        echo json_encode(['status' => true]);

      } catch(\Exception $e) {
        echo json_encode(['status' => false]);
        dd($e->getMessage());
     }
    }
  }

  public function excluirProdutoPedido($idProdutoPedido)
  {
    $produtoPedido = new ProdutoPedido();
    $dadosProdutoPedido = $produtoPedido->find($idProdutoPedido);

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
    $idProdutoPedido = $this->post->data()->idProdutoPedido;
    try {
      $produtoPedido->alterarQuantidadeProdutoPedido(
        $idProdutoPedido,
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

  public function obterValorTotalDosProdutos($idPedido)
  {
    $pedido = new Pedido();
    $produtoPedido = new ProdutoPedido();
    $valorTotalDosProdutos = $produtoPedido->valorTotalDoPedido($idPedido)->total;

    echo json_encode([
      'totalGeral' => $valorTotalDosProdutos
    ]);
  }

  public function alterarSituacaoPedido()
  {
    if ($this->post->hasPost()) {
      $pedido = new Pedido();

      try {
        $pedido->update(
          ['id_situacao_pedido' => $this->post->data()->id_situacao_pedido],
          $this->post->data()->id_pedido
        );
        echo json_encode(['status' => true]);

      } catch(\Exception $e) {
        echo json_encode(['status' => false]);
        dd($e->getMessage());
     }
    }
  }

  public function modalFormulario($idPedido = false)
  {
    $pedido = false;
    $clienteEnderecos = false;

    $usuario = new Usuario();
    $usuario = $usuario->find($this->idUsuarioLogado);

    $cliente = new Cliente();
    $clientes = $cliente->clientes($this->idEmpresa);

    $produto = new Produto();
    $produtos = $produto->produtos($this->idEmpresa);

    $meioPagamento = new MeioPagamento();
    $meiosPagamentos = $meioPagamento->all();

    if ($idPedido) {
      $pedido = new Pedido();
      $pedido = $pedido->find($idPedido);

      $clienteEndereco = new ClienteEndereco();
      $clienteEnderecos = $clienteEndereco->enderecos($pedido->id_cliente);
    }

    $this->view('pedido/formulario', null,
      compact(
        'idPedido',
        'pedido',
        'usuario',
        'clientes',
        'produtos',
        'meiosPagamentos',
        'clienteEnderecos'
      ));
  }

  public function enderecoPorIdCliente($idCliente)
  {
    $clienteEndereco = new ClienteEndereco();
    echo json_encode($clienteEndereco->enderecos($idCliente));
  }
}

