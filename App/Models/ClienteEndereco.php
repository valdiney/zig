<?php

namespace App\Models;

use System\Model\Model;

class ClienteEndereco extends Model
{
    protected $table = 'clientes_enderecos';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function enderecos($idCliente)
    {
        return $this->query("SELECT * FROM clientes_enderecos WHERE id_cliente = {$idCliente}");
    }
}
