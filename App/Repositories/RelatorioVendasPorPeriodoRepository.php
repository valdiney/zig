<?php 
namespace App\Repositories;
use App\Models\Venda;
use App\Services\RelatorioPDFService\GerarRelatorioDeVendasPorPeriodoPDFService;
use App\Services\RelatorioXlsService\GerarRelatorioDeVendasPorPeriodoXlsService;

class RelatorioVendasPorPeriodoRepository
{
    protected $venda;

    public function __construct()
    {
        $venda = new Venda();
        $this->venda = $venda;
    }

	public function vendasPorPeriodo(array $periodo, $idUsuario = false, $idEmpresa = false)
	{
		$de = $periodo['de'];
		$ate = $periodo['ate'];

		$queryPorUsuario = false;
		if ($idUsuario) {
			$queryPorUsuario = "AND vendas.id_usuario = {$idUsuario}";
		}

		$query = $this->venda->query("
			SELECT vendas.id, vendas.valor, DATE_FORMAT(vendas.created_at, '%H:%i') AS hora,
			DATE_FORMAT(vendas.created_at, '%d/%m/%Y') AS data,
            meios_pagamentos.legenda, usuarios.id, usuarios.nome AS nomeUsuario, usuarios.imagem,
            vendas.preco, vendas.quantidade,
            produtos.id AS idProduto, produtos.nome AS nomeProduto
            FROM vendas INNER JOIN usuarios
            ON vendas.id_usuario = usuarios.id
            INNER JOIN meios_pagamentos ON vendas.id_meio_pagamento = meios_pagamentos.id
            LEFT JOIN produtos ON vendas.id_produto = produtos.id
            WHERE vendas.id_empresa = {$idEmpresa} AND DATE(vendas.created_at) 
            BETWEEN '{$de}' AND '{$ate}' {$queryPorUsuario}
            ORDER BY vendas.created_at DESC");

		return $query;
	}

	public function totalVendidoPorMeioDePagamento(array $periodo, $idUsuario = false, $idEmpresa = false)
    {
        $de = $periodo['de'];
		$ate = $periodo['ate'];

		$queryPorUsuario = false;
		if ($idUsuario) {
			$queryPorUsuario = "AND vendas.id_usuario = {$idUsuario}";
		}

        $query = $this->venda->query(
            "SELECT meios_pagamentos.id AS idMeioPagamento, 
            meios_pagamentos.legenda, SUM(vendas.valor) AS totalVendas FROM vendas 
            INNER JOIN meios_pagamentos ON vendas.id_meio_pagamento = meios_pagamentos.id
            WHERE vendas.id_empresa = {$idEmpresa}
            AND DATE(vendas.created_at) BETWEEN '{$de}' AND '{$ate}' {$queryPorUsuario}
            GROUP BY vendas.id_meio_pagamento"
        );

        return $query;
    }

    public function totalDasVendas(array $periodo, $idUsuario = false, $idEmpresa = false)
    {
        $de = $periodo['de'];
		$ate = $periodo['ate'];

		$queryPorUsuario = false;
		if ($idUsuario) {
			$queryPorUsuario = "AND vendas.id_usuario = {$idUsuario}";
		}

        $query = $this->venda->query(
            "SELECT SUM(valor) AS totalVendas FROM vendas WHERE id_empresa = {$idEmpresa}
            AND DATE(vendas.created_at) BETWEEN '{$de}' AND '{$ate}' {$queryPorUsuario}"
        );

        return $query[0]->totalVendas;
    }

    public function gerarRelatioDeVendasPorPeriodoXls(array $periodo, $idUsuario = false, $idEmpresa = false)
    {
        $periodo = ['de' => $periodo['de'], 'ate' => $periodo['ate']];
        $vendas = $this->vendasPorPeriodo($periodo, $idUsuario, $idEmpresa);

        $gerarXls = new GerarRelatorioDeVendasPorPeriodoXlsService();
        $gerarXls->setDiretorio('public/arquivos_temporarios');
        $gerarXls->setNomeDoArquivo('Relatorio de vendas por periodo'.$idEmpresa);

        $gerarXls->setPeriodo([
            'de' => date('d/m/Y', strtotime($periodo['de'])),
            'ate' => date('d/m/Y', strtotime($periodo['ate']))
        ]);

        $gerarXls->gerarXsl($vendas);
    }

    public function gerarRelatioDeVendasPorPeriodoPDF(array $periodo, $idUsuario = false, $idEmpresa = false)
    {
        $periodo = ['de' => $periodo['de'], 'ate' => $periodo['ate']];
        $vendas = $this->vendasPorPeriodo($periodo, $idUsuario, $idEmpresa);

        $gerarXls = new GerarRelatorioDeVendasPorPeriodoPDFService();
        $gerarXls->setDiretorio('public/arquivos_temporarios');
        $gerarXls->setNomeDoArquivo('Relatorio de vendas por periodo'.$idEmpresa);

        $gerarXls->setPeriodo([
            'de' => date('d/m/Y', strtotime($periodo['de'])),
            'ate' => date('d/m/Y', strtotime($periodo['ate']))
        ]);

        $gerarXls->gerarPDF($vendas);
    }
}