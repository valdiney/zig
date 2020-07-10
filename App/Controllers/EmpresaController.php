<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;
use App\Rules\Logged;
use App\Rules\UsuarioPermissaoRule;

use App\Models\Empresa;
use App\Models\ClienteSegmento;
use App\Models\ConfigPdv;
use App\Models\Usuario;

class EmpresaController extends Controller
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

		$logged = new Logged();
		$logged->isValid();

		$usuarioPermissaoRule = new UsuarioPermissaoRule();
		$usuarioPermissaoRule->isValid(3); # O Número (3) é o id do Modulo Empresa
	}

	public function index()
	{
		$empresa = new Empresa();
		$empresas = $empresa->all();

		$this->view('empresa/index', $this->layout, compact("empresas"));
	}

	public function save()
	{
		if ($this->post->hasPost()) {
			$empresa = new Empresa();
			$dados = (array) $this->post->data();

			try {
				$empresa->save($dados);
                
                # Cadastra um tipo de PDV para a Empresa
				$configPdv = new ConfigPdv();
				$configPdv->save([
					'id_empresa' => $empresa->lastId(),
					'id_tipo_pdv' => 1
				]);
                
                # Cadastra um Usuário para empresa
				$usuario = new Usuario();
				$usuario->save([
					'id_empresa' => $empresa->lastId(),
					'nome' => $dados['nome'],
					'email' => $dados['email'],
					'password' => createHash('33473347'),
					'id_sexo' => 1,
					'id_perfil' => 5
				]);
                
				return $this->get->redirectTo("empresa");

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
		$empresa = false;
		
		if ($this->get->position(0)) {
        	$empresa = new Produto();
		    $empresa = $empresa->find($this->get->position(0));
        }

        $segmento = new ClienteSegmento();
        $segmentos = $segmento->all();

		$this->view('empresa/formulario', null, 
			compact(
				'empresa', 
				'segmentos'
			));
	}
}