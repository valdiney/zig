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

	public function faturamentoDeVendasNoMes($mes, $ano, $idCliente)
	{
        $query = $this->venda->query(
            "SELECT SUM(valor) AS faturamentoDeVendas FROM vendas WHERE id_cliente = {$idCliente}
            AND MONTH(created_at) = '{$mes}' AND YEAR(created_at) = '{$ano}'"
        );

        return $query[0]->faturamentoDeVendas;
	}

	public function faturamentoDeVendasNoDia($dia, $mes, $idCliente)
	{
        $query = $this->venda->query(
            "SELECT SUM(valor) AS faturamentoDeVendas FROM vendas WHERE id_cliente = {$idCliente}
            AND DAY(created_at) = '{$dia}' AND MONTH(created_at) = '{$mes}'"
        );

        return $query[0]->faturamentoDeVendas;
	}
}