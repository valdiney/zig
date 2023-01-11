<?php

namespace App\Models;

use System\Model\Model;
use App\Repositories\RelatorioVendasPorPeriodoRepository;

class FluxoCaixa extends Model
{
    protected $table = 'fluxo_caixa';
    protected $timestamps = true;
    protected $retirarPDVdoFluxoDeCaixa = false;
    protected $vendas;

    const TIPO_PERIODO_LANCAMENTO = "lancamento";
    const TIPO_PERIODO_VENCIMENTO = "vencimento";

    public function __construct()
    {
        $this->vendas = new RelatorioVendasPorPeriodoRepository();
        parent::__construct();
    }

    public function fluxoDeCaixa(array $periodo, $idEmpresa)
    {
        $de = $periodo['de'];
        $ate = $periodo['ate'];

        try {
            $query = $this->queryGetOne(
                "SELECT
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 1
                        AND DATE(created_at) BETWEEN '{$de}' AND '{$ate}') AS entradas,
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 0
                        AND DATE(created_at) BETWEEN '{$de}' AND '{$ate}') AS saidas,
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 1
                        AND DATE(created_at) BETWEEN '{$de}' AND '{$ate}') -
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 0
                AND DATE(created_at) BETWEEN '{$de}' AND '{$ate}') AS restante

                FROM fluxo_caixa WHERE id_empresa = {$idEmpresa}
                AND DATE(created_at) BETWEEN '{$de}' AND '{$ate}'
                GROUP BY DATE(created_at)"
            );

            if ( ! isset($query->scalar)) {
                if (is_null($query->entradas) && ! is_null($query->saidas)) {
                    $query->entradas = 0;
                    $query->restante = $query->entradas - $query->saidas;
                }

                if ( ! is_null($query->entradas) && is_null($query->saidas)) {
                    $query->saidas = 0;
                    $query->restante = $query->entradas - $query->saidas;
                }
            }

            # Vendas vindas do PDV
            $vendas = $this->vendas->totalDasVendas($periodo, false, $idEmpresa);

            # Se marcado retirar PDV do Fluxo de Caixa
            if ($this->getRetirarPDV()) {
              $vendas = null;
            }

            # Tem venda realizada no período
            if ( ! is_null($vendas)) {
                # Nenhum valor no caixa para o período
                if (isset($query->scalar)) {
                    # Seto novas propriedades para não ficar underfined
                    $query = (object) ['entradas' => 0, 'restante' => 0, 'saidas' => 0];
                }

                $query->entradas += $vendas;
                $query->restante = $query->entradas - $query->saidas;
                $query->entradasVendas = $vendas;
            }

            # Se não tiver nenhuma venda e nenhum caixa no período
            if (is_null($vendas) && isset($query->scalar)) {
                # Seto novas propriedade para não ficar underfined
                $query = (object) ['entradas' => 0, 'restante' => 0, 'saidas' => 0];
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }

        return $query;
    }

    public function fluxoDeCaixaDetalhadoPorMes(array $periodo, $tipoPeriodo, $idEmpresa)
    {
        $de = $periodo['de'];
        $ate = $periodo['ate'];

        $queryTipoPeriodo = "DATE(created_at)";
        if ($tipoPeriodo == self::TIPO_PERIODO_VENCIMENTO) {
            $queryTipoPeriodo = "DATE(data)";
        }

        $query = $this->query(
            "SELECT * FROM fluxo_caixa WHERE id_empresa = {$idEmpresa}
            AND {$queryTipoPeriodo} BETWEEN '{$de}' AND '{$ate}'"
        );

        # Se marcado retirar PDV do Fluxo de Caixa
        if ($this->getRetirarPDV()) {
            return $query;
        }

        $vendas = $this->vendas->totalDasVendas($periodo, false, $idEmpresa);
        if (count($query) > 0 || ! is_null($vendas)) {
            $vendaDoPdv = new \StdClass;
            $vendaDoPdv->id = 0;
            $vendaDoPdv->id_empresa = 1;
            $vendaDoPdv->id_categoria = 1;
            $vendaDoPdv->descricao = 'Total vendas PDV';
            $vendaDoPdv->data = timestamp();
            $vendaDoPdv->valor = $vendas;
            $vendaDoPdv->tipo_movimento = 1;
            $vendaDoPdv->created_at = timestamp();
            $vendaDoPdv->updated_at = null;
            $vendaDoPdv->deleted_at = null;
            $vendaDoPdv->fromPDV = true;
            array_push($query, $vendaDoPdv);
        }

        return $query;
    }

    public function setRetirarPDV(bool $retirarPDV): void
    {
        $this->retirarPDVdoFluxoDeCaixa = $retirarPDV;
    }

    public function getRetirarPDV(): bool
    {
        return $this->retirarPDVdoFluxoDeCaixa;
    }
}
