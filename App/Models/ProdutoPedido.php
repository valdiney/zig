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

  public function produtos($idPedido, $idEmpresa = false)
  {
    return $this->query(
      "SELECT * FROM produtos WHERE id_empresa = {$idEmpresa}"
    );
  }

  public function adicionarProdutoNoPedido($produto, $quantidade, $idVendedor)
  {
    if ( ! isset($_SESSION['itensPedido'])) {
      $_SESSION['itensPedido'][$idVendedor] = [];
    }

    if ( ! isset($_SESSION['itensPedido'][$idVendedor][$produto->id])) {
      $_SESSION['itensPedido'][$idVendedor][$produto->id] = [
        'id' => $produto->id,
        'nome' => $produto->nome,
        'imagem' => $produto->imagem,
        'quantidade' => $quantidade,
        'preco' => $produto->preco,
        'subTotal' => (float) $produto->preco * (float) $quantidade
      ];
    }

    return $_SESSION['itensPedido'];
  }

  public function retirarProdutoDoPedido($produto, $idVendedor)
  {
    if (isset($_SESSION['itensPedido'][$idVendedor][$produto->id])) {
      unset($_SESSION['itensPedido'][$idVendedor][$produto->id]);
      return true;
    }

    return false;
  }

  public function produtosAdicionadosPorIdProdutoEIdVendedor($idProduto, $idVendedor)
  {
    return $_SESSION['itensPedido'][$idVendedor][$idProduto];
  }

  public function retornaProdutoAdicionado($idVendedor)
  {
    return end($_SESSION['itensPedido'][$idVendedor]);
  }
}
