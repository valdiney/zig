<?php

namespace App\Controllers;

use App\Models\LogAcesso;
use App\Models\Perfil;
use App\Models\Usuario;
use App\Rules\Logged;
use App\Services\LoginRemeber\LoginRemeber;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;

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

        $logged = new Logged();
        $logged->logged();
    }

    public function index()
    {
        $this->view('login/index', $this->layout);
    }

    public function logar()
    {
        $email = $this->post->data()->email;
        $password = $this->post->data()->password;
        $mustRememberLogin = $this->post->data()->remember === "on";

        $usuario = new Usuario();
        $dadosUsuario = $usuario->findBy('email', $email);

        if ($usuario->userExist(['email' => $email, 'password' => $password])) {
            # Grava o Log de Acessos
            $log = new LogAcesso();
            $dados = [];
            $dados['id_usuario'] = $dadosUsuario->id;
            $dados['id_empresa'] = $dadosUsuario->id_empresa;
            $log->save($dados);

            $perfil = new Perfil();
            $perfil = $perfil->find($dadosUsuario->id_perfil);

            # Coloca dados necessarios na sessão
            Session::set('idUsuario', $dadosUsuario->id);
            Session::set('idPerfil', $dadosUsuario->id_perfil);
            Session::set('legendaPerfil', $perfil->descricao);
            Session::set('idEmpresa', $dadosUsuario->id_empresa);
            Session::set('nomeUsuario', $dadosUsuario->nome);
            Session::set('idSexoUsuario', $dadosUsuario->id_sexo);
            Session::set('emailUsuario', $dadosUsuario->email);
            Session::set('imagem', $dadosUsuario->imagem);

            if ($mustRememberLogin) {
                $this->handleRememberUser($dadosUsuario);
            }

            return $this->get->redirectTo("home");
        }

        Session::flash('error', 'Usuário não encontrado!');
        return $this->get->redirectTo("login");
    }

    private function handleRememberUser($user)
    {
        $loginRemember = new LoginRemeber($user);
        $loginRemember->execute();
    }

    public function logout()
    {
        $this->removeRememberToken();
        Session::logout();
        return $this->get->redirectTo("login");
    }

    private function removeRememberToken()
    {
        $loginRemember = new LoginRemeber();
        $usuario = new Usuario();
        $hash = $loginRemember->getRememberCookie();

        if ( ! is_null($hash)) {
            $user = (new Usuario)->findBy('remember_token', $hash);
            $data = [
                "remember_token" => null,
                "remember_expire_date" => null,
            ];
            $usuario->update($data, $user->id);
            $loginRemember->deleteRememberCookie();
        }
    }
}
