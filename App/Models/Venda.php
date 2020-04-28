<?php
namespace App\Models;

use System\Model\Model;

class Venda extends Model
{
    protected $table = 'vendas';
    protected $timestamps = true;

    public function __construct()
    {
    	parent::__construct();
    }

    public function vendasGeralDoDia($idCliente, $quantidade = false)
    {
        $data = date('Y-m-d');
        $queryContidade = false;
        if ($quantidade) {
            $queryContidade = "LIMIT {$quantidade}";
        }

    	return $this->query(
    		"SELECT 
            vendas.id, vendas.valor, DATE_FORMAT(vendas.created_at, '%H:%i') AS data,
            meios_pagamentos.legenda, usuarios.id, usuarios.nome, usuarios.imagem 
            FROM vendas INNER JOIN usuarios
            ON vendas.id_usuario =  usuarios.id
            INNER JOIN meios_pagamentos ON vendas.id_meio_pagamento = meios_pagamentos.id
            WHERE vendas.id_cliente = {$idCliente} AND DATE(vendas.created_at) = '{$data}'
            ORDER BY vendas.created_at DESC {$queryContidade}"
    	);
    }

    public function totalVendasNoDia($idCliente)
    {
        $data = date('Y-m-d');

        $query = $this->query(
            "SELECT SUM(valor) AS totalVendas FROM vendas WHERE id_cliente = {$idCliente}
            AND DATE(created_at) = '{$data}'"
        );

        return $query[0]->totalVendas;
    }
}