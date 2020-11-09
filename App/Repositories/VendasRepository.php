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
			ROUND((COUNT(*) / (SELECT COUNT(*) FROM vendas WHERE vendas.created_at BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -30 DAY) AND CURRENT_DATE())),2) * 100 AS media
			FROM vendas
			INNER JOIN meios_pagamentos AS mpg ON vendas.id_meio_pagamento = mpg.id
			WHERE DATE(vendas.created_at) BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
			AND vendas.id_empresa = {$idEmpresa}
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
		$query = $this->venda->query(
      "SELECT DATE_FORMAT(created_at, '%d/%m') AS data, COUNT(*) AS quantidade FROM vendas
      WHERE DATE(created_at) BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
      AND id_empresa = {$idEmpresa}
      GROUP BY DAY(created_at) ORDER BY DATE_FORMAT(created_at, '%d/%m') DESC
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
      SELECT usuarios.id AS idUsuario, usuarios.nome, usuarios.imagem,
      SUM(vendas.valor) AS valor, DATE_FORMAT(vendas.created_at, '%m')
      FROM vendas INNER JOIN usuarios ON vendas.id_usuario = usuarios.id
      WHERE vendas.id_empresa = {$idEmpresa} AND
      DATE_FORMAT(vendas.created_at, '%m') = {$mes}
      GROUP BY usuarios.nome, usuarios.id
    ");

    $dados = [];
    foreach ($query as $venda) {

      $dados[$venda->idUsuario]['nome'] = $venda->nome;
      $dados[$venda->idUsuario]['total'] = $venda->valor;
      $dados[$venda->idUsuario]['imagem'] = $venda->imagem;

      $meioPagamentos = $this->totalVendasUsuariosPorMeioDePagamento(
        $idEmpresa,
        $venda->idUsuario,
        date('m')
      );

      if (count($meioPagamentos) > 0) {
        foreach ($meioPagamentos as $meioPagamento) {
          $dados[$venda->idUsuario]['meios_pagamento'][] = (array) $meioPagamento;
        }
      }
    }

    return $dados;
  }

  public function totalVendasUsuariosPorMeioDePagamento($idEmpresa, $idUsuario, $mes)
  {
    $query = $this->venda->query("
      SELECT meios_pagamentos.id, meios_pagamentos.legenda, SUM(vendas.valor) AS total
      FROM vendas INNER JOIN meios_pagamentos ON vendas.id_meio_pagamento = meios_pagamentos.id
      WHERE vendas.id_usuario = {$idUsuario} AND vendas.id_empresa = {$idEmpresa}
      AND DATE_FORMAT(vendas.created_at, '%m') = {$mes}
      GROUP BY vendas.id_meio_pagamento
    ");

    return $query;
  }
}


/*
SELECT DAY(created_at) AS DATA, COUNT(*) FROM vendas
WHERE MONTH(created_at) = MONTH(NOW())
GROUP BY DAY(created_at)
*/
