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
      $queryPorCliente = false;
      if ($idCliente) {
        $queryPorCliente = "AND pedidos.id_cliente = {$idCliente}";
      }

      return $this->query(
         "SELECT pedidos.id AS idPedido, clientes.nome AS nomeCliente,
          IF(pedidos.previsao_entrega = '0000-00-00', 'Não informado', DATE_FORMAT(pedidos.previsao_entrega, '%d/%m/%Y')) AS previsaoEntrega,
          pedidos.valor_frete AS valorFrete, pedidos.id_situacao_pedido,
          pedidos.valor_desconto AS valordesconto,
          situacao.legenda AS situacao,

          (SELECT SUM(subtotal) FROM produtos_pedidos
            WHERE produtos_pedidos.id_pedido = pedidos.id
          ) + pedidos.valor_frete - pedidos.valor_desconto AS totalGeral

          FROM pedidos INNER JOIN clientes ON pedidos.id_cliente = clientes.id
          LEFT JOIN situacoes_pedidos AS situacao ON pedidos.id_situacao_pedido = situacao.id
          WHERE pedidos.id_vendedor = {$idVendedor} {$queryPorCliente} ORDER BY pedidos.id"
      );
    }
}
