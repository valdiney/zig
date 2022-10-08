<?php

namespace App\Controllers;

use App\Models\Perfil;
use App\Models\Sexo;
use App\Models\Usuario;
use App\Rules\Logged;
use App\Services\SendEmail\SendEmail;
use App\Services\UploadService\UploadFiles;
use Exception;
use System\Controller\Controller;
use System\Get\Get;
use System\HtmlComponents\SendEmailTemplate\SimpleTemplate;
use System\Post\Post;
use System\Session\Session;

class UsuarioController extends Controller
{
    protected $post;
    protected $get;
    protected $layout;
    protected $idEmpresa;
    protected $idUsuarioLogado;
    protected $idPerfilUsuarioLogado;

    protected $diretorioImagemUsuarioNoEnv;
    protected $diretorioImagemUsuarioPadrao;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'default';

        $this->post = new Post();
        $this->get = new Get();
        $this->idEmpresa = Session::get('idEmpresa');
        $this->idUsuarioLogado = Session::get('idUsuario');
        $this->idPerfilUsuarioLogado = session::get('idPerfil');

        $path = filter_var(getenv('SHARED_HOST'), FILTER_VALIDATE_BOOLEAN) ? 'imagem/perfil_usuarios/' : 'public/imagem/perfil_usuarios/';
        $this->diretorioImagemUsuarioPadrao = $path;

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
            $dados = (array)$this->post->data();
            $dados['password'] = createHash($dados['password']);

            # Valida imagem somente se existir no envio
            if (!empty($_FILES["imagem"]['name'])) {
                $diretorioImagem = $this->diretorioImagemUsuarioPadrao;
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

                $dados['imagem'] = filter_var(getenv('SHARED_HOST'), FILTER_VALIDATE_BOOLEAN) ? "public/{$retornoImagem}" : $retornoImagem;
            }

            try {
                # Cadastra Usuário
                $usuario->save($dados);
                return $this->get->redirectTo("usuario");

            } catch (Exception $e) {
                dd('Erro ao cadastrar Usuário ' . $e->getMessage());
            }
        }
    }

    public function update()
    {
        if ($this->post->hasPost()) {
            $usuario = new Usuario();
            $dadosUsuario = $usuario->find($this->post->data()->id);

            $dados = (array)$this->post->only([
                'nome', 'email', 'password',
                'id_sexo', 'id_perfil'
            ]);

            if (!empty($_FILES["imagem"]['name'])) {

                if (file_exists($dadosUsuario->imagem)) {
                    # Deleta a imagem anterior
                    unlink($dadosUsuario->imagem);
                }

                $diretorioImagem = $this->diretorioImagemUsuarioPadrao;
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

                $dados['imagem'] = filter_var(getenv('SHARED_HOST'), FILTER_VALIDATE_BOOLEAN) ? "public/{$retornoImagem}" : $retornoImagem;
            }

            if (!is_null($this->post->data()->password)) {
                $dados['password'] = createHash($this->post->data()->password);
            } else {
                unset($dados['password']);
            }

            try {
                $usuario->update($dados, $dadosUsuario->id);

                # Se o usuário estiver editando a propria imagem, seta a mesma na sessão
                if ($this->post->data()->id == Session::get('idUsuario')) {
                    Session::set('imagem', $dados['imagem']);
                }

                return $this->get->redirectTo("usuario");

            } catch (Exception $e) {
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

    function desativarUsuario($idUsuario)
    {
        $cliente = new Usuario();
        $dados['deleted_at'] = date('Y-m-d H:i:s');

        try {
            $cliente->update($dados, $idUsuario);
            echo json_encode(['status' => true]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    function ativarUsuario($idUsuario)
    {
        $cliente = new Usuario();
        $dados['deleted_at'] = null;

        try {
            $cliente->update($dados, $idUsuario);
            echo json_encode(['status' => true]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
