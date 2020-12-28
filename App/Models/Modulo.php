<?php

namespace App\Models;

use System\Model\Model;

class Modulo extends Model
{
    protected $table = 'modulos';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function modulos()
    {
        return $this->all();
    }
}
