<?php
namespace App\Models;

use System\Model\Model;

class ProdutoPedido extends Model
{
  protected $table = 'produtos_pedidos';
  protected $timestamps = true;

  public function __construct()
  {
    parent::__construct();
  }

  public function produtos($idEmpresa = false)
  {
    return $this->query(
      "SELECT * FROM produtos WHERE id_empresa = {$idEmpresa}"
    );
  }

  public function produtosPorIdPedido($idPedido = false)
  {
    return $this->query(
      "SELECT * FROM produtos_pedidos WHERE id_pedido = {$idPedido}"
    );
  }
}
