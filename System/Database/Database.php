<?php

namespace System\Database;

use PDO;
use System\Database\Access;

class Database
{
  private static $connectionTypes = [
    'mysql' => \System\Database\Modules\MySQL::class
  ];

  protected static $conn = null;
  protected static $stmt = null;
  protected static $join = [];
  protected static $primaryKey = "id";
  protected static $sql = "";
  protected static $tableName = "";
  protected static $columns = "*";
  protected static $command = "";
  protected static $limit = "";
  protected static $order = "";
  protected static $from = "";
  protected static $where = [];
  protected static $update = [];
  protected static $data = [];

  public static function conn(string $name = null)
  {
    self::$conn = self::getConnection($name);
    return new self;
  }

  public static function table(string $table)
  {
    if (self::$conn == null) {
      self::$conn = self::getConnection();
    }
    self::$tableName = $table;
    return new self;
  }

  public static function select()
  {
    $columns = count(func_get_args())? implode(',', func_get_args()): self::$columns;
    $columns = $columns ?? '*';
    self::$command = "SELECT";
    self::$columns = $columns;
    self::$from = "FROM ";
    return new self;
  }

  public static function limit(int $position = 0, int $take = 1)
  {
    self::$limit = "LIMIT {$position}, {$take}";
    return new self;
  }

  public static function primary(string $key)
  {
    self::$primaryKey = $key;
  }

  public static function order(string $column, string $type = 'ASC')
  {
    self::$order = "ORDER BY `{$column}` {$type}";
    return new self;
  }

  public static function orderDesc(string $column)
  {
    return self::order($column, "DESC");
  }

  public static function all()
  {
    self::select();
    self::limit();
    return self::fetchAll();
  }

  public static function first()
  {
    self::select();
    self::limit();
    return self::fetch();
  }

  public static function last()
  {
    self::$order = "ORDER BY " . self::$primaryKey . " DESC";
    self::select();
    self::limit();
    return self::fetch();
  }

  public static function where()
  {
    if (count(func_get_args())==1 && is_array(func_get_arg(0))) {
      $items = func_get_arg(0);
      foreach ($items as $key => $value) {
        self::where($key, $value);
      }
      return new self;
    }
    $column = func_get_arg(0);
    $key = ":{$column}";
    $type = count(func_get_args()) == 2? '=': func_get_arg(1);
    $data = count(func_get_args()) == 2? func_get_arg(1): func_get_arg(2);
    self::$where[] = "`{$column}` {$type} {$key}";
    self::$data[$key] = $data;
    return new self;
  }

  public static function outerJoin(string $table, $localKey, $foreign)
  {
    return self::join($table, $localKey, $foreign, "OUTER JOIN");
  }

  public static function innerJoin(string $table, $localKey, $foreign)
  {
    return self::join($table, $localKey, $foreign, "INNER JOIN");
  }

  public static function leftJoin(string $table, $localKey, $foreign)
  {
    return self::join($table, $localKey, $foreign, "LEFT JOIN");
  }

  public static function rightJoin(string $table, $localKey, $foreign)
  {
    return self::join($table, $localKey, $foreign, "RIGHT JOIN");
  }

  public static function join(string $table, $localKey, $foreign, string $type = "JOIN")
  {
    self::$from = "FROM";
    self::$join[] = "{$type} {$table} ON ".self::$tableName.".{$localKey} = {$foreign}";
    return new self;
  }

  public static function find(string $key)
  {
    self::select();
    self::limit();
    self::where(self::$primaryKey, $key);
    return self::fetch();
  }

  public static function get()
  {
    self::$command = "SELECT";
    return self::fetchAll();
  }

  public static function update(array $items = [])
  {
    self::$command = "UPDATE";
    self::$columns = '';
    foreach ($items as $column => $value) {
      $key = ":{$column}";
      self::$update[] = "`{$column}` = {$key}";
      self::$data[$key] = $value;
    }
    return self::finalize();
  }

  public static function delete()
  {
    self::$command = "DELETE";
    self::$from = "FROM";
    self::$columns = "";
    //
    self::finalize();
    self::$stmt->execute(self::$data);
  }

  protected static function finalize()
  {
    self::mountSQL();
    self::$stmt = self::$conn->prepare(self::$sql);
  }

  protected static function mountSQL()
  {
    $where = implode(' AND ', self::$where);
    $where = $where ? "WHERE {$where}" : '';
    //
    $update = implode(', ', self::$update);
    $update = $update ? "SET {$update}" : '';
    //
    $join = implode(' ', self::$join) ?? '';
    //
    self::$sql = sprintf("%s %s %s `%s` %s %s %s %s;", self::$command, self::$columns, self::$from, self::$tableName, $update, $where, $join, self::$order, self::$limit);
    dd(self::$sql);
  }

  protected static function fetch()
  {
    self::finalize();
    self::$stmt->execute(self::$data);
    return self::$stmt->fetch();
  }

  protected static function fetchAll()
  {
    self::finalize();
    self::$stmt->execute(self::$data);
    return self::$stmt->fetchAll();
  }

  private static function getConnection(string $name = null): PDO
  {
    $config = include __DIR__ . '/../../App/Config/Database.php';
    // se não for passado nome, pega o default
    $name = $name ?? $config['connection'];
    if (!isset($config['connections'][$name])) {
      return self::throwError("A conexão '{$name}' não foi encontrada!");
    }
    $config = $config['connections'][$name];
    // cria uma nova conexão
    $connection = self::$connectionTypes[$name];
    $access = new Access($connection, $config);
    return $access->connection();
  }

  private static function throwError($message = null)
  {
    $trace = debug_backtrace();
    array_shift($trace);
    $message = $message ?? 'Erro encontrado na conexão com o banco!';
    $code = "general";
    $viewPath = "{$code}.php";
    require_once(__DIR__ . '/Views/layout.php');
    exit;
  }
}
