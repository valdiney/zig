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

    public function produtos($idCliente)
    {
    	return $this->query(
    		"SELECT * FROM produtos WHERE id_cliente = {$idCliente}"
    	);
    }
}