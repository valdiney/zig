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

    public function usuarios()
    {
    	return $this->query(
    		"SELECT 
            usuarios.id AS id, usuarios.nome,
            usuarios.email, usuarios.id_sexo, 
            usuarios.created_at, usuarios.imagem,
            sexos.descricao, perfis.descricao AS perfil

            FROM usuarios INNER JOIN sexos ON 
    		usuarios.id_sexo = sexos.id 
            INNER JOIN perfis ON usuarios.id_perfil = perfis.id"
    	);
    }
}