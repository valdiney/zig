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
    return (object) $this->query(
      "SELECT p.id, p.nome AS produto, p.preco, p.imagem,
      pd.quantidade, pd.subtotal AS total
      FROM produtos_pedidos AS pd
      INNER JOIN produtos AS p ON pd.id_produto = p.id
      WHERE pd.id_pedido = {$idPedido}"
    );
  }
}
