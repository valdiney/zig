<?php
namespace System\Database;
use App\Config\Config;
use System\Database\Eloquent;

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
