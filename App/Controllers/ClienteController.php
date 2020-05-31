<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

use App\Models\Cliente;
use App\Models\ClienteSegmento;
use App\Models\ClienteTipo;

class ClienteController extends Controller
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
		$clientes = $cliente->clientes($this->idEmpresa);

		$this->view('cliente/index', $this->layout, compact("clientes"));
	}

	public function save()
	{
		if ($this->post->hasPost()) {
			$cliente = new Cliente();
			$dados = (array) $this->post->data();
			$dados['id_empresa'] = $this->idEmpresa;

			try {
				$cliente->save($dados);
				return $this->get->redirectTo("cliente/index");

			} catch(\Exception $e) { 
    		    dd($e->getMessage());
    	    }
		}
	}

	public function update()
	{
		$cliente = new Cliente();
		$dadosCliente = $cliente->find($this->post->data()->id);
		$dados = (array) $this->post->only([
		    'id_cliente_tipo', 'id_cliente_segmento', 
			'nome', 'email', 'cnpj', 'cpf', 'telefone', 'celular'
		]);

		$dados['id_empresa'] = $this->idEmpresa;

		try {
			$cliente->update($dados, $dadosCliente->id);
			return $this->get->redirectTo("cliente/index");

		} catch(\Exception $e) { 
		    dd($e->getMessage());
    	}
	}

	public function modalFormulario()
	{
		$cliente = false;
		
		if ($this->get->position(0)) {
        	$cliente = new Cliente();
		    $cliente = $cliente->find($this->get->position(0));
        }

        $clienteTipo = new ClienteTipo();
        $clientesTipos = $clienteTipo->all();

        $clienteSegmento = new ClienteSegmento();
        $clientesSegmentos = $clienteSegmento->all();

		$this->view('cliente/formulario', null, 
			compact(
				'cliente',
				'clientesTipos',
				'clientesSegmentos'
			));
	}

	public function verificaSeEmailExiste()
	{
		$cliente = new Cliente();
		
		if ($cliente->verificaSeEmailExiste(out64($this->get->position(0)))) {
			echo json_encode(['status' => true]);
		} else {
			echo json_encode(['status' => false]);
		}
	}
}