<?php
namespace App\Models;

use System\Model\Model;

class UsuarioModulo extends Model
{
    protected $table = 'usuarios_modulos';
    protected $timestamps = true;

    public function __construct()
    {
    	parent::__construct();
    }

    public function usuariosModulosPorIdEmpresaEIdUsuario($idEmpresa, $idUsuario)
    {
    	return $this->query("
    		SELECT modulos.id AS idModulo, usm.id AS idUsuarioModulo, 
    		usm.id_usuario AS idUsuario, usm.id_empresa AS idEmpresa, modulos.descricao AS nomeModulo,
            usm.consultar, usm.criar, usm.editar, usm.excluir, usm.created_at, usm.updated_at
            FROM usuarios_modulos AS usm
            INNER JOIN modulos ON usm.id_modulo = modulos.id
            WHERE usm.id_empresa = {$idEmpresa} AND usm.id_usuario = {$idUsuario}
    	");
    }
}