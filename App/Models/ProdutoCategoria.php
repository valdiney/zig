<?php

namespace App\Models;

use System\Model\Model;

class ProdutoCategoria extends Model
{
    protected $table = 'produtos_categorias';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }
}
