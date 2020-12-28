<?php

namespace App\Models;

use System\Model\Model;

class LogAcesso extends Model
{
    protected $table = 'log_acessos';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function logs($idEmpresa)
    {
        return $this->query("
          SELECT
            log.id, log.id_usuario, log.id_empresa, log.created_at,
            usuarios.nome AS usuario_nome, usuarios.imagem AS usuario_imagem,
            empresas.nome AS empresa_nome
          FROM {$this->table} AS log
            LEFT JOIN usuarios ON log.id_usuario = usuarios.id
            LEFT JOIN empresas ON log.id_empresa = empresas.id
          WHERE log.id_empresa = {$idEmpresa}
          ORDER BY id DESC;
        ");
    }

}
