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
            AND MONTH(created_at) = '{$mes}' AND YEAR(created_at) = '{$ano}'"
        );

        return $query[0]->faturamentoDeVendas;
	}

	public function faturamentoDeVendasNoDia($dia, $mes, $idEmpresa)
	{
        $query = $this->venda->query(
            "SELECT SUM(valor) AS faturamentoDeVendas FROM vendas WHERE id_empresa = {$idEmpresa}
            AND DAY(created_at) = '{$dia}' AND MONTH(created_at) = '{$mes}'"
        );

        return $query[0]->faturamentoDeVendas;
	}

	public function percentualMeiosDePagamento($idEmpresa)
	{
		$query = $this->venda->query("
			SELECT mpg.legenda, SUM(vendas.valor) AS total, 
			ROUND((COUNT(*) / (SELECT COUNT(*) FROM vendas)),2) * 100 AS media
			FROM vendas
			INNER JOIN meios_pagamentos AS mpg ON vendas.id_meio_pagamento = mpg.id
			WHERE vendas.id_empresa = {$idEmpresa}
			GROUP BY vendas.id_meio_pagamento
		");
        
        $legendas = [];
        $medias = [];
		foreach ($query as $valor) {
			array_push($legendas, $valor->legenda);
			array_push($medias, $valor->media);
		}

		return (object) ['legendas' => $legendas, 'medias' => $medias];
	}
}


/*
SELECT DAY(created_at) AS DATA, COUNT(*) FROM vendas
WHERE MONTH(created_at) = MONTH(NOW())
GROUP BY DAY(created_at)
*/