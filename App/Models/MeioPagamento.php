<?php

namespace App\Models;

use System\Model\Model;

class MeioPagamento extends Model
{
    protected $table = 'meios_pagamentos';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }
}
