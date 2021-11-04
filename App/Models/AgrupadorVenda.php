<?php

namespace App\Models;

use System\Model\Model;

class AgrupadorVenda extends Model
{
    protected $table = 'agupador_vendas';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }
}
