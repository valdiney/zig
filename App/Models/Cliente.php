<?php

namespace App\Models;

use System\Model\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function clientes($idEmpresa)
    {
        return $this->query("SELECT(
            SELECT COUNT(*) FROM clientes_enderecos WHERE id_cliente = cl.id
            ) AS quantidadeEnderecos,
            cl.id, cl.nome, cl.email, cl.cnpj, cl.cpf, cl.telefone, cl.celular, cl.deleted_at,
            cs.id AS idSegmento, cs.descricao AS descricaoSegmento,
            ct.id AS idClienteTipo, ct.descricao AS descricaoClienteTipo
            FROM clientes AS cl
            LEFT JOIN clientes_segmentos AS cs ON cl.id_cliente_segmento = cs.id
            LEFT JOIN clientes_tipos AS ct ON cl.id_cliente_tipo = ct.id
            WHERE cl.id_empresa = {$idEmpresa} ORDER BY cl.nome");
    }

    public function verificaSeEmailExiste($email)
    {
        if (!$email) {
            return false;
        }

        $query = $this->query("SELECT * FROM clientes WHERE email = '{$email}'");
        if (count($query) > 0) {
            return true;
        }

        return false;
    }

    public function verificaSeCnpjExiste($cnpj)
    {
        if (!$cnpj) {
            return false;
        }

        $query = $this->query("SELECT * FROM clientes WHERE cnpj = '{$cnpj}'");
        if (count($query) > 0) {
            return true;
        }

        return false;
    }

    public function verificaSeCpfExiste($cpf)
    {
        if (!$cpf) {
            return false;
        }

        $query = $this->query("SELECT * FROM clientes WHERE cpf = '{$cpf}'");
        if (count($query) > 0) {
            return true;
        }

        return false;
    }

    public function seDadoNaoPertenceAoClienteEditado($nomeDoCampo, $valor, $idCliente)
    {
        $dadosCliente = $this->findBy("{$nomeDoCampo}", $valor);
        if ($dadosCliente && $idCliente != $dadosCliente->id) {
            return true;
        }

        return false;
    }

    public function quantidadeDeClientesCadastrados($idEmpresa)
    {
        $ativos = $this->queryGetOne("
            SELECT COUNT(*) quantidade FROM clientes WHERE id_empresa = {$idEmpresa} AND deleted_at IS NULL
        ");

        $inativos = $this->queryGetOne("
            SELECT COUNT(*) quantidade FROM clientes WHERE id_empresa = {$idEmpresa} AND deleted_at IS NOT NULL
        ");

        return (object)[
            'ativos' => $ativos->quantidade,
            'inativos' => $inativos->quantidade
        ];
    }
}
