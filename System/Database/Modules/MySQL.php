<?php

namespace System\Database\Modules;

use PDO;
use System\Database\Module;

class MySQL implements Module
{
  public static function connect(array $data)
  {
    $host = $data['host'];
    $user = $data['user'];
    $pass = $data['pass'];
    $db   = $data['db'];
    return new PDO("mysql:host={$host};dbname={$db}", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  }
}
