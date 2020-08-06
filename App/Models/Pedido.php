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

    public function pedidos($idVendedor = false, $idCliente = false)
    {
      return $this->query("SELECT pedidos.id AS idPedido, clientes.nome AS nomeCliente,
        pedidos.previsao_entrega AS previsaoEntrega, pedidos.total,
        situacao.legenda AS situacao
        FROM pedidos INNER JOIN clientes ON pedidos.id_cliente = clientes.id
        INNER JOIN situacoes_pedidos AS situacao ON pedidos.id_situacao_pedido = situacao.id
        WHERE pedidos.id_vendedor = {$idVendedor}
      ");
    }
}
