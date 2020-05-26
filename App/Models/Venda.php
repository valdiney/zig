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
}