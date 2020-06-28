<?php
namespace App\Rules;
use System\Get\Get;
use System\Session\Session;

use App\Models\Modulo;
use App\Models\UsuarioModulo;

class UsuarioPermissaoRule
{
    protected $get;

    public function __construct()
    {
        $this->get = new Get();
    }

    public function isValid($idUsuario, $idModulo)
    {
          
    }
}