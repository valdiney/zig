<?php

namespace App\Models;

use System\Model\Model;

class ClienteTipo extends Model
{
    protected $table = 'clientes_tipos';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }
}
