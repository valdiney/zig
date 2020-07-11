<?php

namespace System\Database;

use PDO;

interface Module
{
  /**
   * Retorna a string de conexão com o tipo de banco
   */
  public static function connect(array $data);
}
