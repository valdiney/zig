<?php

namespace App\Models;

use System\Model\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function produtos($idEmpresa)
    {
        return $this->query(
            "SELECT * FROM produtos WHERE id_empresa = {$idEmpresa} AND deleted_at IS NULL"
        );
    }

    public function quantidadeDeProdutosCadastrados($idEmpresa)
    {
        $ativos = $this->queryGetOne("
            SELECT COUNT(*) quantidade FROM produtos WHERE id_empresa = {$idEmpresa} AND deleted_at IS NULL
        ");

        $inativos = $this->queryGetOne("
            SELECT COUNT(*) quantidade FROM produtos WHERE id_empresa = {$idEmpresa} AND deleted_at IS NOT NULL
        ");

        return (object)[
            'ativos' => $ativos->quantidade,
            'inativos' => $inativos->quantidade
        ];
    }
}
