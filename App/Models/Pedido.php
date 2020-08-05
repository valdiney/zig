<?php
namespace App\Models;

use System\Model\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $timestamps = true;

    public function __construct()
    {
      parent::__construct();
    }

    public function pedidos($idCliente)
    {
        return $this->all();
    }
}
