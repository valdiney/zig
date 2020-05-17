<?php 
namespace App\Repositories;
use App\Models\Venda;

class RelatorioVendasPorPeriodoRepository
{
	public function vendasPorPeriodo(array $periodo, $idUsuario = false, $idCliente = false)
	{
		$venda = new Venda();

		$de = $periodo['de'];
		$ate = $periodo['ate'];

		$queryPorUsuario = false;
		if ($idUsuario) {
			$queryPorUsuario = "AND vendas.id_usuario = {$idUsuario}";
		}

		$query = $venda->query("
			SELECT vendas.id, vendas.valor, DATE_FORMAT(vendas.created_at, '%H:%i') AS hora,
			DATE_FORMAT(vendas.created_at, '%d/%m/%Y') AS data,
            meios_pagamentos.legenda, usuarios.id, usuarios.nome, usuarios.imagem 
            FROM vendas INNER JOIN usuarios
            ON vendas.id_usuario =  usuarios.id
            INNER JOIN meios_pagamentos ON vendas.id_meio_pagamento = meios_pagamentos.id
            WHERE vendas.id_cliente = {$idCliente} AND DATE(vendas.created_at) 
            BETWEEN '{$de}' AND '{$ate}' {$queryPorUsuario}
            ORDER BY vendas.created_at DESC");

		return $query;
	}

	public function totalVendidoPorMeioDePagamento(array $periodo, $idUsuario = false, $idCliente = false)
    {
    	$venda = new Venda();

        $de = $periodo['de'];
		$ate = $periodo['ate'];

		$queryPorUsuario = false;
		if ($idUsuario) {
			$queryPorUsuario = "AND vendas.id_usuario = {$idUsuario}";
		}

        $query = $venda->query(
            "SELECT meios_pagamentos.id AS idMeioPagamento, 
            meios_pagamentos.legenda, SUM(vendas.valor) AS totalVendas FROM vendas 
            INNER JOIN meios_pagamentos ON vendas.id_meio_pagamento = meios_pagamentos.id
            WHERE vendas.id_cliente = {$idCliente}
            AND DATE(vendas.created_at) BETWEEN '{$de}' AND '{$ate}' {$queryPorUsuario}
            GROUP BY vendas.id_meio_pagamento"
        );

        return $query;
    }

    public function totalDasVendas(array $periodo, $idUsuario = false, $idCliente = false)
    {
    	$venda = new Venda();

        $de = $periodo['de'];
		$ate = $periodo['ate'];

		$queryPorUsuario = false;
		if ($idUsuario) {
			$queryPorUsuario = "AND vendas.id_usuario = {$idUsuario}";
		}

        $query = $venda->query(
            "SELECT SUM(valor) AS totalVendas FROM vendas WHERE id_cliente = {$idCliente}
            AND DATE(vendas.created_at) BETWEEN '{$de}' AND '{$ate}' {$queryPorUsuario}"
        );

        return $query[0]->totalVendas;
    }
}