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

use App\Services\UploadService\UploadFiles;
use App\Services\SendEmail\SendEmail;

use System\HtmlComponents\SendEmailTemplate\SimpleTemplate;

class UsuarioController extends Controller
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
		$usuario = new Usuario();
		$usuarios = $usuario->usuarios(
			$this->idEmpresa,
			$this->idUsuarioLogado,
			$this->idPerfilUsuarioLogado
		);

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
        return $this->get->redirectTo("usuario");

			} catch(\Exception $e) {
    		dd('Erro ao cadastrar Usuário ' . $e->getMessage());
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

	public function modalFormulario($idUsuario)
	{
		$sexo = new Sexo();
		$sexos = $sexo->all();

		$perfil = new Perfil();
		$perfis = $perfil->perfis(false, false, Session::get('idPerfil'));

    $usuario = false;
    if ($idUsuario) {
    	$usuario = new Usuario();
      $usuario = $usuario->find($idUsuario);

      $perfis = $perfil->perfis(
      	$this->idUsuarioLogado,
      	$idUsuario,
      	Session::get('idPerfil')
      );
    }

		$this->view('usuario/formulario', null,
			compact(
				'sexos',
				'usuario',
				'perfis'
			));
	}

  public function verificaSeEmailExiste($email, $idUsuario = false)
  {
    $email = out64($email);
    $usuario = new Usuario();

    /*
    * Se for uma edição,
    * verifica se o EMAIL não pertence ao usuario que está sendo editado no momento
    */
    if ($idUsuario && $email) {
      if ($usuario->seDadoNaoPertenceAoUsuarioEditado('email', $email, $idUsuario)) {
        echo json_encode(['status' => true]);
        return false;
      }
    }

    if ($usuario->verificaSeEmailExiste($email)) {
      echo json_encode(['status' => true]);
    } else {
      echo json_encode(['status' => false]);
    }
  }

  public function testeEmail()
  {
    $sendEmail = new SendEmail();
    $sendEmail->setFrom("contato@tonie.com.br");
    $sendEmail->setTo("valdiney.2@hotmail.com");
    $sendEmail->setSubject("Bem vindo - Confirmação de cadastro");

    $mensagem = "<b>Valdiney</b>,
    sejá bem vindo ao sistema <b>Tonie.</b>
    Você foi cadastrado por <b>João Batista</b>";

    $sendEmail->setBody(SimpleTemplate::template($mensagem));

    dd($sendEmail->send());
  }
}
