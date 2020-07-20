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

	public function quantidadeDeVendasRealizadasPorDia(array $periodo, $idEmpresa)
	{
		$query = $this->venda->query("
			SELECT DATE_FORMAT(created_at, '%d/%m') AS data, COUNT(*) AS quantidade FROM vendas
			WHERE MONTH(created_at) = MONTH(NOW()) AND id_empresa = {$idEmpresa}
			GROUP BY DAY(created_at) ORDER BY DATE_FORMAT(created_at, '%d/%m') ASC
		");

		return $query;
	}

	public function valorDeVendasRealizadasPorDia(array $periodo, $idEmpresa)
	{
		$query = $this->venda->query("
			SELECT DATE_FORMAT(created_at, '%d/%m') AS data, SUM(valor) AS valor FROM vendas
			WHERE MONTH(created_at) = MONTH(NOW()) AND id_empresa = {$idEmpresa}
			GROUP BY DAY(created_at) ORDER BY DATE_FORMAT(created_at, '%d/%m') ASC
		");

		return $query;
	}

  public function totalVendasPorUsuariosNoMes($idEmpresa, $mes)
  {
    $query = $this->venda->query("
      SELECT usuarios.id, usuarios.nome, usuarios.imagem,
      SUM(vendas.valor) AS valor, DATE_FORMAT(vendas.created_at, '%m')
      FROM vendas INNER JOIN usuarios ON vendas.id_usuario = usuarios.id
      WHERE vendas.id_empresa = {$idEmpresa} AND
      DATE_FORMAT(vendas.created_at, '%m') = {$mes}
      GROUP BY usuarios.nome, usuarios.id
    ");

    return $query;
  }

  public function totalVendasUsuariosPorMeioDePagamento($idEmpresa, $mes)
  {
    $query = $this->venda->query(

    );
  }
}


/*
SELECT DAY(created_at) AS DATA, COUNT(*) FROM vendas
WHERE MONTH(created_at) = MONTH(NOW())
GROUP BY DAY(created_at)
*/
