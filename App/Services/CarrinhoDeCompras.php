<?php

namespace App\Services\CarrinhoDeCompras;

use Exception;

class CarrinhoDeCompras
{
    protected $identificador;

    public function __construct(string $identificador)
    {
        $this->identificador = $identificador;
    }

    public function inserirProduto(object $produto, int $quantidade)
    {
        if ($idProduto) {
            if (!isset($this->obterSessaoEmUso()[$idProduto])) {
                if (!$quantidade) {
                    $quantidade = 1;
                }

                $this->obterSessaoEmUso()[$idProduto] = [
                    'id' => $produto->id,
                    'nome' => $produto->nome,
                    'preco' => $produto->preco,
                    'imagem' => $produto->imagem,
                    'quantidade' => $quantidade,
                    'total' => (float)$produto->preco * (float)$quantidade
                ];
            }
        }

        return $this->obterSessaoEmUso();
    }

    public function obterProdutos()
    {
        if (isset($this->obterSessaoEmUso()[$idProduto])) {
            return $this->obterSessaoEmUso();
        }

        return false;
    }

    public function retirarProduto(object $produto)
    {
        if (isset($this->obterSessaoEmUso()[$produto->id])) {
            try {
                unset($this->obterSessaoEmUso()[$produto->id]);
                return true;
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
    }

    private function obtemSessaoEmUso()
    {
        if (!isset($_SESSION[$this->identificador])) {
            $_SESSION[$this->identificador] = [];
        }

        return $_SESSION[$this->identificador];
    }
}
