<?php
namespace App\Models;

use System\Model\Model;

class Perfil extends Model
{
    protected $table = 'perfis';
    protected $timestamps = true;

    public function __construct()
    {
    	parent::__construct();
    }
}