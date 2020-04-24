<?php
namespace System\Database;
use System\Database\Eloquent;
use System\Database\Native;

use App\Config\Config;

class Database
{
    function __construct() 
    {
        $configs = Config::getConfigs();
  
        if ($configs['DBNATIVE']) {
            //Native::connect();
        } else {
            //Eloquent::connect();
        }
    }
}