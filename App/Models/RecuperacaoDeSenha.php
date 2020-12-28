<?php

namespace App\Models;

use System\Model\Model;

class RecuperacaoDeSenha extends Model
{
    protected $table = 'recuperacao_de_senha';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }
}
