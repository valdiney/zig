<?php

namespace App\Models;

use System\Model\Model;
use App\Repositories\RelatorioVendasPorPeriodoRepository;

class FluxoCaixa extends Model
{
    protected $table = 'fluxo_caixa';
    protected $timestamps = true;
    protected $incluirVendasNoCaixa = 1;
    protected $vendas;

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
            $query = $this->query(
                "SELECT
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 1
                        AND DATE(created_at) BETWEEN '2022/10/03' AND '2022/10/03') AS entradas,
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 0
                        AND DATE(created_at) BETWEEN '2022/10/03' AND '2022/10/03') AS saidas,
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 1
                        AND DATE(created_at) BETWEEN '2022/10/03' AND '2022/10/03') -
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 0
                AND DATE(created_at) BETWEEN '2022/10/03' AND '2022/10/03') AS restante

                FROM fluxo_caixa WHERE id_empresa = {$idEmpresa}
                AND DATE(created_at) BETWEEN '{$de}' AND '{$ate}'
                GROUP BY DATE(created_at)"
            );

            if (count($query) > 0) {
                $query = $query[0];
                $vendas = $this->vendas->totalDasVendas($periodo, false, $idEmpresa);
                if ($this->incluirVendasNoCaixa && ! is_null($vendas)) {
                    $query->entradas += $vendas;
                    $query->restante = $query->entradas - $query->saidas;
                    $query->entradasVendas = $vendas;
                }
            } else {
                $query = (object) $query;
                $query->entradas = 0;
                $query->saidas = 0;
                $query->restante = 0;
                $query->entradasVendas = 0;
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }

        return $query;
    }

    public function fluxoDeCaixaDetalhadoPorMes(array $periodo, $idEmpresa)
    {
        $de = $periodo['de'];
        $ate = $periodo['ate'];

        $query = $this->query(
            "SELECT * FROM fluxo_caixa WHERE id_empresa = {$idEmpresa}
            AND DATE(created_at) BETWEEN '{$de}' AND '{$ate}'"
        );

        if (count($query) > 0) {
            $vendas = $this->vendas->totalDasVendas($periodo, false, $idEmpresa);
            if ($this->incluirVendasNoCaixa && ! is_null($vendas)) {
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
        }

        return $query;
    }
}
