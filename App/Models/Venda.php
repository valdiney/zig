<?php

namespace App\Models;

use System\Model\Model;

class Venda extends Model
{
    protected $table = 'vendas';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function seJaExisteCodigoDeVenda($codigo, $idEmpresa)
    {
        $query = $this->query("SELECT * FROM vendas WHERE codigo_venda = '{$codigo}' AND id_empresa = {$idEmpresa}");
        if (count($query) > 0) {
            return true;
        }

        return false;
    }
}
