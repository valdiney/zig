<?php

namespace App\Repositories;

use App\Models\Produto;

/**
 * Repositório controla produtos na sessão que são usados em vendas e pedidos
 */
class VendasEmSessaoRepository
{
    public function colocarProdutosNaMesa($idProduto, $quantidade = false)
    {
        if ($idProduto) {
            if (!isset($_SESSION['venda'])) {
                $_SESSION['venda'] = [];
            }

            if (!isset($_SESSION['venda'][$idProduto])) {
                if (!$quantidade) {
                    $quantidade = 1;
                }

                $produto = new Produto();
                $produto = $produto->find($idProduto);

                $_SESSION['venda'][$idProduto] = [
                    'id' => $idProduto,
                    'produto' => $produto->nome,
                    'preco' => $produto->preco,
                    'imagem' => $produto->imagem,
                    'quantidade' => $quantidade,
                    'total' => (float)$produto->preco * (float)$quantidade
                ];
           }
        }

        return json_encode($_SESSION['venda']);
    }

    public function obterProdutosDaMesa($posicaoProduto = false)
    {
        if (isset($_SESSION['venda'])) {
            if ($posicaoProduto && $posicaoProduto == 'ultimo') {
                return json_encode(end($_SESSION['venda']));
            } else {
                return json_encode($_SESSION['venda']);
            }
        } else {
            return json_encode([]);
        }
    }

    public function idDosProdutosNaMesa()
    {
        $ids = [];
        if (isset($_SESSION['venda'])) {
            foreach ($_SESSION['venda'] as $produto) {
                array_push($ids, $produto['id']);
            }
        }

        return $ids;
    }

    public function alterarAquantidadeDeUmProdutoNaMesa($idProduto, $quantidade)
    {
        if (isset($_SESSION['venda'])) {
            $_SESSION['venda'][$idProduto]['quantidade'] = $quantidade;
            $_SESSION['venda'][$idProduto]['total'] = $quantidade * $_SESSION['venda'][$idProduto]['preco'];
        }
    }

    public function retirarProdutoDaMesa($idProduto)
    {
        if (isset($_SESSION['venda'])) {
            unset($_SESSION['venda'][$idProduto]);
        }
    }

    public function obterValorTotalDosProdutosNaMesa()
    {
        $total = 0;
        if (isset($_SESSION['venda'])) {
            foreach ($_SESSION['venda'] as $produto) {
                $total += $produto['total'];
            }
        }

        return json_encode(['total' => $total]);
    }

    public function limparSessao()
    {
        unset($_SESSION['venda']);
    }

    function colocarProdutosVindosDoBancoDeDadosNaMesa($produto)
    {
        $_SESSION['venda'][$produto->id] = [
            'id' => $produto->id,
            'produto' => $produto->produto,
            'preco' => $produto->preco,
            'imagem' => $produto->imagem,
            'quantidade' => $produto->quantidade,
            'total' => $produto->total,
            'id_pedido' => $produto->id_pedido
        ];
    }

    public function calcularTroco($valorRecebido)
    {
        $valorTotalDosProdutosSelecionados = (double) json_decode($this->obterValorTotalDosProdutosNaMesa())->total;
        $valorRecebido = (double) $valorRecebido;

        if ($valorRecebido < $valorTotalDosProdutosSelecionados) {
            return json_encode(['valor' => 0.00, 'message' => 'O valor pago é insuficiente.']);
        }

        $troco = (double) $valorRecebido - $valorTotalDosProdutosSelecionados;
        return json_encode(['valor' => $troco, 'message' => false]);
    }
}
