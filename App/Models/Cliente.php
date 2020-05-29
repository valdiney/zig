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
    	return $this->query("
    		SELECT cl.id, cl.nome, cl.email, cl.cnpj, cl.cpf, cl.telefone, cl.celular,
			cs.id AS idSegmento, cs.descricao AS descricaoSegmento, 
			ct.id AS idClienteTipo, ct.descricao AS descricaoClienteTipo
			FROM clientes AS cl
			LEFT JOIN clientes_segmentos AS cs ON cl.id_cliente_segmento = cs.id
			LEFT JOIN clientes_tipos AS ct ON cl.id_cliente_tipo = ct.id
			WHERE cl.id_empresa = {$idEmpresa}");
    }
}