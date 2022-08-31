<?php

namespace App\Repositories;

use App\Models\Venda;

class VendasRepository
{
    protected $venda;

    public function __construct()
    {
        $this->venda = new Venda();
    }

    public function faturamentoDeVendasNoMes($mes, $ano, $idEmpresa)
    {
        $query = $this->venda->query(
            "SELECT SUM(valor) AS faturamentoDeVendas FROM vendas WHERE id_empresa = {$idEmpresa}
            AND MONTH(created_at) = '{$mes}' AND YEAR(created_at) = '{$ano}'
            AND vendas.deleted_at IS NULL"
        );

        return $query[0]->faturamentoDeVendas;
    }

    public function faturamentoDeVendasNoDia($dia, $mes, $idEmpresa)
    {
        $query = $this->venda->query(
            "SELECT SUM(valor) AS faturamentoDeVendas FROM vendas WHERE id_empresa = {$idEmpresa}
            AND DAY(created_at) = '{$dia}' AND MONTH(created_at) = '{$mes}'
            AND vendas.deleted_at IS NULL"
        );

        return $query[0]->faturamentoDeVendas;
    }

    public function percentualMeiosDePagamento($idEmpresa)
    {
        $query = $this->venda->query(
            "SELECT mpg.legenda, SUM(vendas.valor) AS total,
			ROUND((COUNT(*) / (SELECT COUNT(*) FROM vendas WHERE id_empresa = {$idEmpresa} AND
            DATE(vendas.created_at) BETWEEN NOW() - INTERVAL 30 DAY AND NOW())), 2) * 100 AS media
            FROM vendas INNER JOIN meios_pagamentos AS mpg ON vendas.id_meio_pagamento = mpg.id
			WHERE DATE(vendas.created_at) BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
            AND vendas.id_empresa = {$idEmpresa}
            AND vendas.deleted_at IS NULL
			GROUP BY vendas.id_meio_pagamento ORDER BY mpg.id"
        );

        $legendas = [];
        $medias = [];
        foreach ($query as $valor) {
            array_push($legendas, $valor->legenda);
            array_push($medias, $valor->media);
        }

        return (object)['legendas' => $legendas, 'medias' => $medias];
    }

    public function quantidadeDeVendasRealizadasPorDia(array $periodo, $idEmpresa)
    {
        $query = $this->venda->query(
            "SELECT DATE_FORMAT(created_at, '%d/%m') AS data, COUNT(*) AS quantidade FROM vendas
            WHERE DATE(created_at) BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
            AND id_empresa = {$idEmpresa} AND vendas.deleted_at IS NULL
            GROUP BY DAY(created_at) ORDER BY DATE_FORMAT(created_at, '%d/%m') DESC
		");

        return $query;
    }

    public function valorDeVendasRealizadasPorDia(array $periodo, $idEmpresa)
    {
        $query = $this->venda->query("SELECT DATE_FORMAT(created_at, '%d/%m') AS data, SUM(valor) AS valor FROM vendas
            WHERE DATE(created_at) BETWEEN NOW() - INTERVAL 30 DAY AND NOW() AND id_empresa = {$idEmpresa}
            AND vendas.deleted_at IS NULL
			GROUP BY DAY(created_at) ORDER BY DATE_FORMAT(created_at, '%d/%m') DESC
		");

        return $query;
    }

    public function totalVendasPorUsuariosNoMes($idEmpresa, $mes)
    {
        $query = $this->venda->query(
            "SELECT usuarios.id AS idUsuario, usuarios.nome, usuarios.imagem,
            usuarios.nome AS nomeUsuario,
            SUM(vendas.valor) AS valor, DATE_FORMAT(vendas.created_at, '%m'), (
                SELECT SUM(vendas.valor) AS total FROM vendas WHERE id_meio_pagamento = 1
                AND id_usuario = usuarios.id AND DATE_FORMAT(vendas.created_at, '%m') = {$mes}
                AND vendas.deleted_at IS NULL
            ) AS Dinheiro, (
                SELECT SUM(vendas.valor) AS total FROM vendas WHERE id_meio_pagamento = 2
                AND id_usuario = usuarios.id AND DATE_FORMAT(vendas.created_at, '%m') = {$mes}
                AND vendas.deleted_at IS NULL
            ) AS Credito, (
                SELECT SUM(vendas.valor) AS total FROM vendas WHERE id_meio_pagamento = 3
                AND id_usuario = usuarios.id AND DATE_FORMAT(vendas.created_at, '%m') = {$mes}
                AND vendas.deleted_at IS NULL
            ) AS Debito, (
                SELECT SUM(vendas.valor) AS total FROM vendas WHERE id_meio_pagamento = 4
                AND id_usuario = usuarios.id AND DATE_FORMAT(vendas.created_at, '%m') = {$mes}
                AND vendas.deleted_at IS NULL
            ) AS Boleto, (
                SELECT SUM(vendas.valor) AS total FROM vendas WHERE id_meio_pagamento = 5
                AND id_usuario = usuarios.id AND DATE_FORMAT(vendas.created_at, '%m') = {$mes}
                AND vendas.deleted_at IS NULL
            ) AS Pix

            FROM vendas INNER JOIN usuarios ON vendas.id_usuario = usuarios.id
            WHERE vendas.id_empresa = {$idEmpresa} AND vendas.id_empresa = {$idEmpresa} AND
            DATE_FORMAT(vendas.created_at, '%m') = {$mes}
            AND vendas.deleted_at IS NULL
            GROUP BY usuarios.nome, usuarios.id ORDER BY vendas.valor DESC
    ");

        return $query;
    }

    public function totalVendasUsuariosPorMeioDePagamento($idEmpresa, $idUsuario, $mes)
    {
        return $this->venda->query(
            "SELECT meios_pagamentos.id, meios_pagamentos.legenda, SUM(vendas.valor) AS total
            FROM vendas INNER JOIN meios_pagamentos ON vendas.id_meio_pagamento = meios_pagamentos.id
            WHERE vendas.id_usuario = {$idUsuario} AND vendas.id_empresa = {$idEmpresa}
            AND DATE_FORMAT(vendas.created_at, '%m') = {$mes}
            AND vendas.deleted_at IS NULL
            GROUP BY vendas.id_meio_pagamento
        ");
    }

    public function produtosMaisVendidosNoMes($idEmpresa, $mes, $quantidade)
    {
        return $this->venda->query(
            "SELECT produtos.imagem, produtos.nome, SUM(vendas.quantidade) AS quantidade,
            SUM(vendas.valor) AS total FROM vendas
            INNER JOIN produtos ON vendas.id_produto = produtos.id
            WHERE vendas.id_empresa = {$idEmpresa} AND MONTH(vendas.created_at) = '{$mes}'
            AND vendas.deleted_at IS NULL
            AND produtos.deleted_at IS NULL
            GROUP BY vendas.id_produto ORDER BY quantidade DESC LIMIT {$quantidade}
        ");
    }

    public function vendasPorMesNoAno($idEmpresa, $ano = false)
    {
        if ( ! $ano)  {
            $ano = date('Y');
        }

        return $this->venda->query(
            "SELECT SUM(valor) AS total, MONTH(created_at) AS mes,
            DATE_FORMAT(created_at, '%m/%Y') periodo
            FROM vendas WHERE YEAR(created_at) = '{$ano}' AND id_empresa = {$idEmpresa}
            GROUP BY MONTH(created_at) ORDER BY MONTH(created_at)
        ");
    }
}




/*
SELECT DAY(created_at) AS DATA, COUNT(*) FROM vendas
WHERE MONTH(created_at) = MONTH(NOW())
GROUP BY DAY(created_at)
*/
