<?php

namespace App\Models;

use System\Model\Model;

class TipoPdv extends Model
{
    protected $table = 'tipos_pdv';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function tiposPdv()
    {
        return $this->all();
    }
}
