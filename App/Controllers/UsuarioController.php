<?php 
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;
use App\Rules\Logged;

use App\Models\Usuario;
use App\Models\Sexo;
use App\Models\Perfil;
use App\Models\Modulo;
use App\Models\UsuarioModulo;

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

		$logged = new Logged();
		$logged->isValid();
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
			
			# Valida imagem somente se existir no envio
			if (isset($dados['imagem'])) {

				# Pega o diretório setado no .env
                $diretorioImagem = getenv('DIRETORIO_IMAGENS_PERFIL_USUARIO');
                if (is_null($diretorioImagem)) {
                	$diretorioImagem = 'public/imagem/perfil_usuarios/';
                }

				$retornoImagem = uploadImageHelper(
					new UploadFiles(), 
					$diretorioImagem, 
					$_FILES["imagem"]
				);
	            
	            # Verifica se houve erro durante o upload de imagem
				if (is_array($retornoImagem)) {
					Session::flash('error', $retornoImagem['error']);
					return $this->get->redirectTo("usuario");
				}
	            
			    $dados['imagem'] = $retornoImagem;
		    }

			try {
				# Cadastra Usuário
				$usuario->save($dados);
			} catch(\Exception $e) { 
    		    dd('Erro ao cadastrar Usuário ' . $e->getMessage());
    	    }

    	    try {
    	    	$modulo = new Modulo();
    	    	$modulos = $modulo->all();
                
                # Criar as Permissões do Usuário
    	    	$usuarioModulo = new UsuarioModulo();
    	    	$usuarioModulo->criarPermissoesAoCadstrarUsuario(
    	    		$modulos,
    	    		$usuario->lastId(),
    	    		$this->idEmpresa,
    	    		$dados['id_perfil']
    	    	);

				return $this->get->redirectTo("usuario");

			} catch(\Exception $e) { 
    		    dd('Erro ao cadastrar Criar Permissões ' . $e->getMessage());
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

                if (file_exists($dadosUsuario->imagem)) {
                	# Deleta a imagem anterior
				    unlink($dadosUsuario->imagem);
                }
                
                # Pega o diretório setado no .env
                $diretorioImagem = getenv('DIRETORIO_IMAGENS_PERFIL_USUARIO');
                if (is_null($diretorioImagem)) {
                	$diretorioImagem = 'public/imagem/perfil_usuarios/';
                }

				$retornoImagem = uploadImageHelper(
					new UploadFiles(), 
					$diretorioImagem, 
					$_FILES["imagem"]
				);

				# Verifica de houve erro durante o upload de imagem
				if (is_array($retornoImagem)) {
					Session::flash('error', $retornoImagem['error']);
					return $this->get->redirectTo("usuario");
				}
                
				$dados['imagem'] = $retornoImagem;
			}

			if ( ! is_null($this->post->data()->password)) {
				$dados['password'] = createHash($this->post->data()->password);
			} else {
				unset($dados['password']);
			}

			try {
				$usuario->update($dados, $dadosUsuario->id);
				return $this->get->redirectTo("usuario");

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
		$perfis = $perfil->perfis(Session::get('idPerfil'));

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