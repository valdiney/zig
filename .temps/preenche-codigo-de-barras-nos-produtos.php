<?php

use System\Database\Native;
use System\NativeQuery\NativeQuery;

function handleAdicionaCodigoNosProdutos(NativeQuery $native, array $produtosId): void
{
    foreach ($produtosId as $produtoId) {
        $codigo = generateRandomCodigoDeBarras($produtoId);
        $payload = [
            'id' => $produtoId,
            'codigo' => $codigo,
        ];
        $native->prepare('UPDATE produtos SET codigo = :codigo WHERE id = :id;', $payload, false);
    }
}

$connection = Native::connect();
$native = new NativeQuery($connection);

$columnExists = $native->query("SHOW COLUMNS FROM produtos LIKE 'codigo'");
if (count($columnExists)) {
    $produtos = $native->query('SELECT id FROM produtos WHERE codigo IS NULL OR codigo = "0" OR codigo = "1";');
    if (!empty($produtos)) {
        $produtosId = array_map(static function ($produto) {
            return $produto->id;
        }, $produtos);
        handleAdicionaCodigoNosProdutos($native, $produtosId);
    }
}
