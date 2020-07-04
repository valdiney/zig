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

    public function isValid($idModulo)
    {
    	$usuarioModulo = new UsuarioModulo();
    	$usuarioModuloPermissoes = unserialize(Session::get('objetoPermissao'));
        
        # Se não tiver ascesso, mas tentar acessar a rota, redireciona
    	if ( ! $usuarioModuloPermissoes[$idModulo][0]->consultar) {
    		$this->get->redirectTo("home");
    	}
    }
}