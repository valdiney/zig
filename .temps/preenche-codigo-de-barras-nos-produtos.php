<?php

use System\Database\Native;
use System\NativeQuery\NativeQuery;

function handleAdicionaCodigoNosProdutos(NativeQuery $native, array $produtosId): void
{
    foreach ($produtosId as $produtoId) {
        $codigo = random_int(111111111, 999999999) . $produtoId;
        $payload = [
            'id' => $produtoId,
            'codigo' => $codigo,
        ];
        $native->prepare('UPDATE produtos SET codigo_de_barras = :codigo WHERE id = :id;', $payload);
    }
}

$connection = Native::connect();
$native = new NativeQuery($connection);
$produtos = $native->query('SELECT id FROM produtos WHERE codigo_de_barras IS NULL;');

if (!is_null($produtos) && !empty($produtos))
{
    $produtosId = array_map(static function ($produto) {
        return $produto->id;
    }, $produtos);
    handleAdicionaCodigoNosProdutos($native, $produtosId);
}
