<?php

namespace App\Models;

use System\Model\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function produtos($idEmpresa, $nome = false)
    {
        $querypesquisaPorNome = false;
        if ($nome) {
            $querypesquisaPorNome = "AND nome LIKE '%{$nome}%'";
        }

        return $this->query(
            "SELECT * FROM produtos WHERE id_empresa = {$idEmpresa}
            AND deleted_at IS NULL {$querypesquisaPorNome}"
        );
    }

    public function quantidadeDeProdutosCadastrados($idEmpresa)
    {
        $ativos = $this->queryGetOne("
            SELECT COUNT(*) quantidade FROM produtos WHERE id_empresa = {$idEmpresa} AND deleted_at IS NULL
        ");

        $inativos = $this->queryGetOne("
            SELECT COUNT(*) quantidade FROM produtos WHERE id_empresa = {$idEmpresa} AND deleted_at IS NOT NULL
        ");

        return (object)[
            'ativos' => $ativos->quantidade,
            'inativos' => $inativos->quantidade
        ];
    }

    public function valorInvestidoEmCompraDeProdutos($idEmpresa)
    {
        return $this->query(
            "SELECT SUM(preco_compra) AS valorInvestido FROM produtos
            WHERE id_empresa = {$idEmpresa}
            AND deleted_at IS NULL"
        )[0];
    }

    public function lucroAtual($idEmpresa)
    {
        return $this->queryGetOne(
            "SELECT SUM(valor) AS lucro FROM vendas WHERE id_empresa = {$idEmpresa} AND deleted_at IS NULL"
        )->lucro;
    }

    public function informacaoesGeraisDosProdutos($idEmpresa)
    {
        return $this->query(
            "SELECT MAX(preco) AS maisCaro, MIN(preco) AS maisBarato
            FROM produtos WHERE id_empresa = {$idEmpresa} AND deleted_at IS NULL"
        )[0];
    }
}
