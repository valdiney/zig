<?php

namespace App\Models;

use System\Model\Model;

class ClienteSegmento extends Model
{
    protected $table = 'clientes_segmentos';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function segmentos()
    {
        return $this->query("SELECT * FROM clientes_segmentos ORDER BY descricao ASC");
    }
}
