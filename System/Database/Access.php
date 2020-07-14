<?php

namespace System\Database;

use PDO;
use PDOException;

class Access
{
  private $connection;

  public function __construct(string $connection, array $config)
  {
    try {
      $this->connection = $connection::connect($config);
      // exibe erro somente em diplay_errors=true
      $this->connection->setAttribute(
        PDO::ATTR_ERRMODE,
        getenv('APP_DISPLAY_ERRORS') == false ? PDO::ERRMODE_SILENT : PDO::ERRMODE_WARNING
      );
      $this->connection->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        $config['fetch'] ?? PDO::FETCH_OBJ
      );
    } catch (PDOException $e) {
      ob_start();
      $trace = $e->getTrace();
      $message = $e->getMessage();
      $code = $e->getCode();
      if (!file_exists(__DIR__ . "/Views/{$code}.php")) {
        $code = "general";
      }
      $viewPath = "{$code}.php";
      require_once(__DIR__ . '/Views/layout.php');
      exit;
    }
  }

  public function connection(): PDO
  {
    return $this->connection;
  }
}
