<?php

namespace App\Models;

use System\Model\Model;
use App\Repositories\VendasRepository;

class FluxoCaixa extends Model
{
    protected $table = 'fluxo_caixa';
    protected $timestamps = true;
    protected $incluirVendasNoCaixa = 1;
    protected $vendas;

    public function __construct()
    {
        $this->vendas = new VendasRepository();
        parent::__construct();
    }

    public function fluxoDeCaixa($idEmpresa)
    {
        try {
            $query = $this->query(
                "SELECT
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 1) AS entradas,
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 0) AS saidas,
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 1) -
                    (SELECT SUM(valor) FROM fluxo_caixa WHERE tipo_movimento = 0) AS restante
                FROM fluxo_caixa WHERE id_empresa = {$idEmpresa} GROUP BY DATE(created_at)"
            )[0];

            if ($this->incluirVendasNoCaixa) {
                $vendas = $this->vendas->faturamentoDeVendasNoMes(date('m'), date('Y'), $idEmpresa);
                $query->entradas += $vendas;
                $query->restante = $query->entradas - $query->saidas;
                $query->entradasVendas = $vendas;
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        return $query;
    }

    public function fluxoDeCaixaDetalhadoPorMes($idEmpresa)
    {
        $query = $this->query("SELECT * FROM fluxo_caixa WHERE id_empresa = {$idEmpresa}");
        if ($this->incluirVendasNoCaixa) {
            $vendas = $this->vendas->faturamentoDeVendasNoMes(date('m'), date('Y'), $idEmpresa);

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
}
