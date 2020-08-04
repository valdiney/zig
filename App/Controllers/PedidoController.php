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
		$this->view('pedido/index', $this->layout);
	}

	public function save()
	{
		echo json_encode(['teste' => $this->post->data()]);
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

    echo json_encode([
      'id' => $produto->id,
      'nome' => $produto->nome,
      'imagem' => $produto->imagem,
      'quantidade' => $quantidade,
      'total' => (float) $produto->preco * (float) $quantidade
    ]);
  }
}

