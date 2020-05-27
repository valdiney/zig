<?php
namespace App\Models;

use System\Model\Model;
use System\Auth\Auth; 

class Usuario extends Model
{
    use Auth; 
    
    protected $table = 'usuarios';
    protected $timestamps = true;

    public function __construct()
    {
    	parent::__construct();
    }

    public function usuarios($idEmpresa, $idPerfilUsuarioLogado = false)
    {   
        # Se o perfil do Usuário logado não for (1), não traz Usuários com este perfil
        $queryCondicional = false;
        if ($idPerfilUsuarioLogado && $idPerfilUsuarioLogado == 1) {
           $queryCondicional = "AND usuarios.id_perfil = 1";
        } else {
            $queryCondicional = "AND usuarios.id_perfil != 1";
        }

    	return $this->query(
    		"SELECT 
            usuarios.id AS id, usuarios.nome,
            usuarios.email, usuarios.id_sexo, 
            usuarios.created_at, usuarios.imagem,
            sexos.descricao, perfis.descricao AS perfil

            FROM usuarios INNER JOIN sexos ON 
    		usuarios.id_sexo = sexos.id 
            INNER JOIN perfis ON usuarios.id_perfil = perfis.id
            WHERE usuarios.id_empresa = {$idEmpresa} {$queryCondicional}"
    	);
    }
}