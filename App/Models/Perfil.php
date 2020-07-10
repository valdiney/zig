<?php
namespace App\Models;

use System\Model\Model;

class Perfil extends Model
{
    protected $table = 'perfis';
    protected $timestamps = true;

    public function __construct()
    {
    	parent::__construct();
    }
    
    public function perfis($idUsuarioLogado = false, $idUsuarioEditado = false, $idPerfilUsuarioLogado)
    {
    	# Se o usuário logado não for um super admin, não traz o registro super admin
    	$condicao = false;
    	if ($idPerfilUsuarioLogado != 1) {
    		$condicao = "WHERE id != 1";
    	}

        if ($idUsuarioLogado && $idUsuarioEditado) {
            if ($idUsuarioLogado == $idUsuarioEditado) {
                return $this->query("SELECT * FROM perfis WHERE id = {$idPerfilUsuarioLogado}");
            }
        }

    	return $this->query("SELECT * FROM perfis {$condicao}");
    }
}