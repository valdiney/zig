<?php
namespace App\Models;

use System\Model\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $timestamps = true;

    public function __construct()
    {
    	parent::__construct();
    }
}