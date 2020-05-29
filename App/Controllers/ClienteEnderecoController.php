<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

use App\Models\Cliente;
use App\Models\ClienteEndereco;

class ClienteEnderecoController extends Controller
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
	}

	public function index()
	{
		$cliente = new Cliente();
		$cliente = $cliente->find(out64($this->get->position(0)));

		$clienteEndereco = new ClienteEndereco();
		$clienteEnderecos = $clienteEndereco->enderecos($cliente->id);

		$this->view('clienteEndereco/index', $this->layout, 
			compact(
				'cliente',
				'clienteEnderecos'
			));
	}

	public function save()
	{
		if ($this->post->hasPost()) {
			$clienteEndereco = new ClienteEndereco();
			$dados = (array) $this->post->data();
			$dados['id_empresa'] = $this->idEmpresa;

			try {
				$clienteEndereco->save($dados);
				return $this->get->redirectTo("clienteEndereco/index", [in64($dados['id_cliente'])]);

			} catch(\Exception $e) { 
    		    dd($e->getMessage());
    	    }
		}
	}

	public function update()
	{
		# Escreva aqui...
	}

	public function modalFormulario()
	{
		$clienteEndereco = false;
		$idCliente = $this->get->position(0);
		
		if ($this->get->position(1)) {
        	$clienteEndereco = new ClienteEndereco();
		    $clienteEndereco = $clienterEndereco->find($this->get->position(0));
        }

		$this->view('clienteEndereco/formulario', null, 
			compact(
				'clienteEndereco',
				'idCliente'
			));
	}
}