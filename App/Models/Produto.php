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

    public function produtos($idEmpresa)
    {
    	return $this->query(
    		"SELECT * FROM produtos WHERE id_empresa = {$idEmpresa}"
    	);
    }

    public function quantidadeDeProdutosCadastrados($idEmpresa)
    {
      $ativos = $this->queryGetOne("
        SELECT COUNT(*) quantidade FROM produtos WHERE id_empresa = {$idEmpresa} AND created_at IS NOT NULL"
      );

      $inativos = $this->queryGetOne("
        SELECT COUNT(*) quantidade FROM produtos WHERE id_empresa = {$idEmpresa} AND created_at IS  NULL"
      );

      return (object) [
        'ativos' => $ativos->quantidade,
        'inativos' => $inativos->quantidade
      ];
    }
}
