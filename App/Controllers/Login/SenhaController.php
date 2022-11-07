<?php

namespace App\Controllers\Login;

use App\Models\LogAcesso;
use App\Models\Perfil;
use App\Models\RecuperacaoDeSenha;
use App\Models\Usuario;
use App\Rules\Logged;
use App\Services\SendEmail\SendEmail;
use Exception;
use System\Controller\Controller;
use System\Get\Get;
use System\HtmlComponents\SendEmailTemplate\SimpleTemplate;
use System\Post\Post;
use System\Session\Session;

class SenhaController extends Controller
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

        $logged = new Logged();
        $logged->logged();
    }


    public function index()
    {
        $this->view('login/senha/index', $this->layout);
    }

    public function recuperar()
    {
        $data = $this->post->data();
        $title = !is_null(getenv('APPLICATION_NAME')) ? getenv('APPLICATION_NAME') : "ZigMoney";

        if (!isset($data->email)) {
            Session::flash('error', 'Digite um email!');
            return $this->get->redirectTo("login/senha");
        }

        $usuario = new Usuario();
        $dadosUsuario = $usuario->findBy('email', $data->email);

        if (!$dadosUsuario) {
            Session::flash('error', 'Email não cadastrado no sistema!');
            return $this->get->redirectTo("login/senha");
        }

        # apaga tokens antigos
        $recuperacao = new RecuperacaoDeSenha;
        $recuperacao->prepare("DELETE FROM `recuperacao_de_senha` WHERE user_id = ?;", [$dadosUsuario->id], false);

        $recuperacao = new RecuperacaoDeSenha;
        $token = base64_encode(createHash(time() . $dadosUsuario->id));
        $recuperacao->save([
            'user_id' => $dadosUsuario->id,
            'hash' => $token,
        ]);

        try {
            $url = BASEURL . "/login/senha/recuperacao/{$token}";

            $sendEmail = new SendEmail();
            $sendEmail->setFrom(getenv('MAIL_USERNAME'));
            $sendEmail->setTo($dadosUsuario->email);
            $sendEmail->setSubject("[{$title}] Recuperar Senha");

            $mensagem = "Olá <b>{$dadosUsuario->nome}</b>,
            este é um email do sistema <b>{$title}</b><br/><br/>
            Alguém solicitou uma recuperação de senha para este email.<br/>
            Caso não tenha sido você, simplesmente ignore esta mensagem!<br/><br/>

            <a href=\"{$url}\"
            target=\"_blank\"
            style=\"background:#007bff;padding:14px 40px;border-radius:45px;color:#fff;font-size:15px;margin:20px 0;display:inline-block;text-decoration:none;\"
            >
                Clique para recuperar sua Senha
            </a>

            <br/><br/>

            ou abra o seguinte endereço em seu navegador:
            <br/><br/>
            {$url}";

            $sendEmail->setBody(SimpleTemplate::template([
                'title' => $title,
                'bodyMessage' => $mensagem
            ]));

            $sendEmail->send();
        } catch (Exception $e) {
            Session::flash('error', 'Algo deu errado!');
            return $this->get->redirectTo("login/senha");
        }

        Session::flash('success', 'Verifique o seu Email!');
        return $this->get->redirectTo("login/senha");
    }

    public function recuperacao($hash)
    {
        $recuperacao = new RecuperacaoDeSenha;
        $recuperacao = $recuperacao->findBy('hash', $hash);

        if (!$recuperacao) {
            Session::flash('error', 'Ops! Token inválido!');
            return $this->get->redirectTo("login/senha");
        }

        $this->view('login/senha/recuperacao', $this->layout, compact("hash"));
    }

    public function update($hash)
    {
        $recuperacaoDeSenha = new RecuperacaoDeSenha;
        $recuperacao = $recuperacaoDeSenha->findBy('hash', $hash);

        if (!$recuperacao) {
            Session::flash('error', 'Ops! Token inválido!');
            return $this->get->redirectTo("login/senha");
        }

        $data = $this->post->data();

        if (!isset($data->password) || !isset($data->password_check)) {
            Session::flash('error', 'Preencha todos os campos!');
            return $this->get->redirectTo("login/senha/recuperacao/{$hash}");
        }

        if (strlen($data->password) < 8) {
            Session::flash('error', 'A senha precisa conter no mínimo 8 caracteres!');
            return $this->get->redirectTo("login/senha/recuperacao/{$hash}");
        }

        if (!preg_match("/\d/", $data->password)) {
            Session::flash('error', 'A senha precisa conter no mínimo um caracter!');
            return $this->get->redirectTo("login/senha/recuperacao/{$hash}");
        }

        if ($data->password != $data->password_check) {
            Session::flash('error', 'As senhas não batem!');
            return $this->get->redirectTo("login/senha/recuperacao/{$hash}");
        }

        $usuario = new Usuario();
        $dadosUsuario = $usuario->find($recuperacao->user_id);
        $password = createHash($data->password);

        $usuario->update([
            'password' => $password
        ], $dadosUsuario->id);

        # Grava o Log de Acessos
        $log = new LogAcesso();
        $dados = [];
        $dados['id_usuario'] = $dadosUsuario->id;
        $dados['id_empresa'] = $dadosUsuario->id_empresa;
        $log->save($dados);

        $perfil = new Perfil();
        $perfil = $perfil->find($dadosUsuario->id_perfil);

        # Coloca dados necessarios na sessão
        Session::set('logged', true);
        Session::set('idUsuario', $dadosUsuario->id);
        Session::set('idPerfil', $dadosUsuario->id_perfil);
        Session::set('legendaPerfil', $perfil->descricao);
        Session::set('idEmpresa', $dadosUsuario->id_empresa);
        Session::set('nomeUsuario', $dadosUsuario->nome);
        Session::set('idSexoUsuario', $dadosUsuario->id_sexo);
        Session::set('emailUsuario', $dadosUsuario->email);
        Session::set('imagem', $dadosUsuario->imagem);

        $recuperacaoDeSenha->prepare("DELETE FROM `recuperacao_de_senha` WHERE user_id = ?;", [$dadosUsuario->id], false);

        return $this->get->redirectTo("home");
    }

}
