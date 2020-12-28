<?php

namespace App\Rules;

use App\Models\LogAcesso;
use App\Models\Perfil;
use App\Models\Usuario;
use App\Services\LoginRemeber\LoginRemeber;
use DateTime;
use stdClass;
use System\Get\Get;
use System\Session\Session;

class Logged
{
    protected $get;

    public function __construct()
    {
        $this->get = new Get();
    }

    /**
     * Este Metodo é usado em todos os controllers ou metodos que deva ser acessado somente
     * por usuarios logados no sistema
     */
    public function isValid()
    {
        if (Session::hasSession('logged')) {
            return true;
        } else {
            $this->get->redirectTo("");
        }
    }

    /**
     * Este Metodo é chamado apenas no Controller de Login
     * Se o usuario estiver logado, não mostra a página de login
     */
    public function logged()
    {
        // não fazer validação caso esteja na rota logout
        if (METHOD_NAME === "logout") {
            return;
        }
        if (Session::hasSession('logged')) {
            return $this->get->redirectTo("home");
        }
        if ($this->mustConnectUserThroughCookie()) {
            return $this->get->redirectTo("home");
        }
    }

    /**
     * Verifica se há algum cookie e se o mesmo é válido
     * @return bool|void
     */
    private function mustConnectUserThroughCookie(): bool
    {
        $loginRemember = new LoginRemeber;
        $hash = $loginRemember->getRememberCookie();
        if (!$hash) {
            return false;
        }

        $user = (new Usuario)->findBy('remember_token', $hash);
        if (!$user) {
            return false;
        }

        $expireDate = $user->remember_expire_date;

        if ($this->isDateInvalid($expireDate)) {
            $this->deleteRememberData($loginRemember, $user);
            return false;
        }

        $this->connectUserThroughCookie($user);

        return true;
    }

    private function isDateInvalid(string $expireDate)
    {
        $expireDate = new DateTime($expireDate);
        $now = new DateTime();

        return $expireDate <= $now;
    }

    private function deleteRememberData(stdClass $loginRemember, $user)
    {
        $loginRemember->deleteRememberCookie();

        $usuario = new Usuario;
        $data = [
            "remember_token" => null,
            "remember_expire_date" => null,
        ];
        $usuario->update($data, $user->id);
    }

    private function connectUserThroughCookie(stdClass $user)
    {
        # Grava o Log de Acessos
        $log = new LogAcesso();
        $dados = [];
        $dados['id_usuario'] = $user->id;
        $dados['id_empresa'] = $user->id_empresa;
        $log->save($dados);

        $perfil = new Perfil();
        $perfil = $perfil->find($user->id_perfil);

        Session::set('logged', true);

        # Coloca dados necessarios na sessão
        Session::set('idUsuario', $user->id);
        Session::set('idPerfil', $user->id_perfil);
        Session::set('legendaPerfil', $perfil->descricao);
        Session::set('idEmpresa', $user->id_empresa);
        Session::set('nomeUsuario', $user->nome);
        Session::set('idSexoUsuario', $user->id_sexo);
        Session::set('emailUsuario', $user->email);
        Session::set('imagem', $user->imagem);
    }
}
