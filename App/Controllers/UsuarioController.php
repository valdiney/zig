<?php 
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

use App\Models\Usuario;
use App\Models\Sexo;
use App\Models\Perfil;

use App\Services\UploadService\UploadFiles;

class UsuarioController extends Controller
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
	}

	public function index()
	{
		$usuario = new Usuario();
		$usuarios = $usuario->usuarios($this->idEmpresa);

		$this->view('usuario/index', $this->layout, compact('usuarios'));
	}

	public function save()
	{
		if ($this->post->hasPost()) {
			$usuario = new Usuario();
			$dados = (array) $this->post->data();
			$dados['password'] = createHash($dados['password']);
			
			$imagem = uploadImageHelper(
				new UploadFiles(), 
				'public/imagem/perfil_usuarios/', 
				$_FILES["imagem"]
			);
            
		    $dados['imagem'] = $imagem;

			try {
				$usuario->save($dados);
				return $this->get->redirectTo("usuario/index");

			} catch(\Exception $e) { 
    		    dd($e->getMessage());
    	    }
		} 
	}

	public function update()
	{
		if ($this->post->hasPost()) {
			$usuario = new Usuario();
			$dadosUsuario = $usuario->find($this->post->data()->id);

			$dados = (array) $this->post->only([
				'nome', 'email', 'password', 
				'id_sexo', 'id_perfil'
			]);

			if ( ! empty($_FILES["imagem"]['name'])) {

                # Deleta a imagem anterior
				unlink($dadosUsuario->imagem);

				$imagem = uploadImageHelper(
					new UploadFiles(), 
					'public/imagem/perfil_usuarios/', 
					$_FILES["imagem"]
				);
                
				$dados['imagem'] = $imagem;
			}

			if ( ! is_null($this->post->data()->password)) {
				$dados['password'] = createHash($this->post->data()->password);
			} else {
				unset($dados['password']);
			}

			try {
				$usuario->update($dados, $dadosUsuario->id);
				return $this->get->redirectTo("usuario/index");

			} catch(\Exception $e) { 
    		    dd($e->getMessage());
    	    }
		}
	}

	public function modal()
	{
		$sexo = new Sexo();
		$sexos = $sexo->all();

		$perfil = new Perfil();
		$perfis = $perfil->all();
        
        $usuario = false;

        if ($this->get->position(0)) {
        	$usuario = new Usuario();
		    $usuario = $usuario->find($this->get->position(0));
        }
		
		$this->view('usuario/formulario', null, 
			compact(
				'sexos', 
				'usuario',
				'perfis'
			));
	}
}