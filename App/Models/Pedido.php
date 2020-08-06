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

    /**
      * Calcula o valor total do pedido levendo-se em concideração
      * o valor do desconto e valor do frete
    */
    public function valorTotalDoPedido($dados)
    {
      $total = $dados['total'];
      $desconto = $dados['valor_desconto'];
      $frete = $dados['valor_frete'];

      # Verifica se o valor do desconto foi colocado no pedido
      if ( ! empty($desconto)) {
        $total -= $desconto;
      }

      # Verifica se o valor do frete foi colocado no pedido
      if ( ! empty($frete)) {
        $total += $frete;
      }

      return $total;
    }
}
