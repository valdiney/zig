<?php
namespace App\Rules;
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
        } else  {
          $this->get->redirectTo("");
        }
    }

    /**
    * Este Metodo é chamado apenas no Controller de Login
    * Se o usuario estiver logado, não mostra a página de login
    */
    public function logged()
    {
        if (Session::hasSession('logged')) {
            $this->get->redirectTo("home");
        }
    }
}
