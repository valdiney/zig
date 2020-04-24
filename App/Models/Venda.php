<?php
namespace App\Models;

use System\Model\Model;
use System\Auth\Auth; 

class Venda extends Model
{
    protected $table = 'vendas';
    protected $timestamps = true;

    public function __construct()
    {
    	parent::__construct();
    }

    public function vendas()
    {
    	return $this->query(
    		""
    	);
    }
}