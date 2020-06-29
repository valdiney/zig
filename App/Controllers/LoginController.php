<?php 
namespace App\Controllers;

use App\Models\LogAcesso;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;

use App\Models\Usuario;
use App\Models\UsuarioModulo;

class LoginController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;

	public function __construct()
	{
		parent::__construct();
		$this->layout = 'login';

		$this->post = new Post();
		$this->get = new Get();
	}

	public function index()
	{
		$this->view('login/index', $this->layout);
	}

	public function logar()
	{
		if ($this->post->hasPost()) {
			$email = $this->post->data()->email;
			$password = $this->post->data()->password;

			$usuario = new Usuario();
			$dadosUsuario = $usuario->findBy('email', $email);
           
			if ($usuario->userExist(['email' => $email, 'password' => $password])) {

				# Grava o Log de Acessos
		        $log = new LogAcesso();
		        $dados = [];
		        $dados['id_usuario'] = $dadosUsuario->id;
		        $dados['id_empresa'] = $dadosUsuario->id_empresa;
		        $log->save($dados);
				
				# Coloca dados necessarios na sessão
				Session::set('idUsuario', $dadosUsuario->id);
				Session::set('idPerfil', $dadosUsuario->id_perfil);
				Session::set('idEmpresa', $dadosUsuario->id_empresa);
				Session::set('nomeUsuario', $dadosUsuario->nome);
				Session::set('idSexoUsuario', $dadosUsuario->id_sexo);
				Session::set('emailUsuario', $dadosUsuario->email);
				Session::set('imagem', $dadosUsuario->imagem);

                # Coloca na sessão o Objeto de permissões do Usuario
				$usuarioModulo = new UsuarioModulo();

				Session::set('objetoPermissao', serialize(
					$usuarioModulo->usuariosModulosPorIdUsuario($dadosUsuario->id)
				));

				return $this->get->redirectTo("home");
			}
            
            Session::flash('error', 'Usuário não encontrado!');
			return $this->get->redirectTo("login");
		}
	}

	public function logout()
	{
		Session::logout();
		return $this->get->redirectTo("login");
	}
}