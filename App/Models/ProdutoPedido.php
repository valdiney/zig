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
      pd.quantidade, pd.subtotal AS total, pd.id_pedido
      FROM produtos_pedidos AS pd
      INNER JOIN produtos AS p ON pd.id_produto = p.id
      WHERE pd.id_pedido = {$idPedido}"
    );
  }

  # Retorna dados do produto e produto pedido
  public function produtoPorIdProdutoPedido($idProdutoPedido = false)
  {
    return (object) $this->query(
      "SELECT pd.id AS idProdutoPedido, p.id AS idProduto, p.nome AS produto, p.preco, p.imagem,
      pd.quantidade, pd.subtotal AS total, pd.id_pedido
      FROM produtos_pedidos AS pd
      INNER JOIN produtos AS p ON pd.id_produto = p.id
      WHERE pd.id = {$idProdutoPedido}"
    );
  }

  public function excluirProdutoPedido($idProdutoPedido)
  {
    return $this->query("DELETE FROM produtos_pedidos WHERE id = {$idProdutoPedido}", false);
  }

  public function seNaoExisteProdutoNoPedido($idProduto, $idPedido)
  {
    $query = $this->query("SELECT * FROM produtos_pedidos WHERE id_produto = {$idProduto} AND id_pedido = {$idPedido}");
    if (count($query) < 1) {
      return true;
    }

    return false;
  }

  public function deletarProdutosDescartados($idProduto, $idPedido)
  {
    return $this->query("DELETE FROM produtos_pedidos WHERE id_pedido = {$idPedido} AND id_produto = {$idProduto}");
  }

  public function updateProdutos(array $dados)
  {
    $this->query("UPDATE produtos_pedidos SET
      preco = {$dados['preco']},
      quantidade = {$dados['quantidade']},
      subtotal = {$dados['subtotal']}
      WHERE id_pedido = {$dados['id_pedido']} AND id_produto = {$dados['id_produto']}"
    );
  }
}

