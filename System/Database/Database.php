<?php

namespace System\Database;

use System\Database\Access;
use PDO;

class Database extends DatabaseCore
{
  private static $connectionTypes = [
    'mysql' => \System\Database\Modules\MySQL::class
  ];

  protected static $conn = null;
  protected static $stmt = null;
  protected static $join = [];
  protected static $primaryKey = "id";
  protected static $shortname = "";
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

  /**
   * Passa uma nova conexão para o banco de dados.
   * As conexões estão dentro de ./App/Config/Database.php
   *
   * @param string $name
   * @return Database
   */
  public static function conn(string $name = null): Database
  {
    self::$conn = self::getConnection($name);
    return new self;
  }

  /**
   * Seleciona uma tabela no banco
   *
   * @param string $table
   * @return Database
   */
  public static function table(string $table): Database
  {
    if (self::$conn == null) {
      self::$conn = self::getConnection();
    }
    self::$tableName = $table;
    return new self;
  }

  public static function as(string $shortname): Database
  {
    self::$shortname = $shortname;
    return new self;
  }

  /**
   * Passa as colunas que serão selecionadas
   *
   * @return Database
   */
  public static function select(): Database
  {
    $columns = count(func_get_args())? implode(',', func_get_args()): self::$columns;
    $columns = $columns ?? '*';
    self::$command = "SELECT";
    self::$columns = $columns;
    self::$from = "FROM";
    return new self;
  }

  /**
   * Adiciona limite às consultas
   *
   * @param integer $position começa por qual
   * @param integer $take toma quantos
   * @return Database
   */
  public static function limit(int $position = 0, int $take = 1): Database
  {
    self::$limit = "LIMIT {$position}, {$take}";
    return new self;
  }

  /**
   * Seta primary_key da tabela
   *
   * @param string $key
   * @return Database
   */
  public static function primary(string $key): Database
  {
    self::$primaryKey = $key;
    return new self;
  }

  /**
   * Seta order
   *
   * @param string $column
   * @param string $type
   * @return Database
   */
  public static function order(string $column, string $type = 'ASC'): Database
  {
    self::$order = "ORDER BY {$column} {$type}";
    return new self;
  }

  /**
   * Seta order decresecente
   *
   * @param string $column
   * @return Database
   */
  public static function orderDesc(string $column): Database
  {
    return self::order($column, "DESC");
  }

  /**
   * Retorna todos os dados da consulta
   *
   * @return array
   */
  public static function all(): array
  {
    self::select();
    self::limit();
    return self::fetchAll();
  }

  /**
   * Retorna o primeiro item da consulta
   *
   * @return void
   */
  public static function first()
  {
    self::select();
    self::limit();
    return self::fetch();
  }

  /**
   * Retorna o último dado da consulta
   *
   * @return void
   */
  public static function last()
  {
    self::$order = "ORDER BY " . self::$primaryKey . " DESC";
    self::select();
    self::limit();
    return self::fetch();
  }

  /**
   * Método where do banco de dados
   *
   * @return Database
   */
  public static function where(): Database
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
    $key = str_replace('.','_', $key);
    $type = count(func_get_args()) == 2? '=': func_get_arg(1);
    $data = count(func_get_args()) == 2? func_get_arg(1): func_get_arg(2);
    self::$where[] = "{$column} {$type} {$key}";
    self::$data[$key] = $data;
    return new self;
  }

  /**
   * Método join do banco.
   * Passar toda a string de join: INNER JOIN teste as t ON t.id = outra.teste_id
   *
   * @param string $join
   * @return Database
   */
  public static function join(string $join): Database
  {
    self::$from = "FROM";
    self::$join[] = $join;
    return new self;
  }

  /**
   * Seleciona um único dado da tabela pelo primary key
   *
   * @param string $key
   * @return void
   */
  public static function find(string $key)
  {
    self::select();
    self::limit();
    self::where(self::$primaryKey, $key);
    return self::fetch();
  }

  /**
   * Retorna todos os dados da consulta
   *
   * @return array
   */
  public static function get(): array
  {
    self::$command = self::$command ? self::$command : "SELECT";
    self::$from    = self::$from ? self::$from : "FROM";
    return self::fetchAll();
  }

  /**
   * Retorna a consulta SQL
   *
   * @return void
   */
  public static function toSQL()
  {
    self::$command = self::$command? self::$command: "SELECT";
    self::$from    = self::$from? self::$from: "FROM";
    self::mountSQL();
    return self::$sql;
  }

  /**
   * Executa um update dos itens.
   * Não se esqueça de passar o ->where(...) !!!
   *
   * @param array $items
   * @return void
   */
  public static function update(array $items = [])
  {
    self::$command = "UPDATE";
    self::$columns = '';
    foreach ($items as $column => $value) {
      $key = ":{$column}";
      self::$update[] = "{$column} = {$key}";
      self::$data[$key] = $value;
    }
    return self::finalize();
  }

  /**
   * Deleta dados do banco.
   * Não esqueça de passar o ->where(...)!
   *
   * @return void
   */
  public static function delete()
  {
    self::$command = "DELETE";
    self::$from = "FROM";
    self::$columns = "";
    //
    self::finalize();
    self::$stmt->execute(self::$data);
  }

  /**
   * Monta a consulta sql e dá o prepare do PDO
   *
   * @return void
   */
  protected static function finalize()
  {
    self::mountSQL();
    self::$stmt = self::$conn->prepare(self::$sql);
  }

  /**
   * Monta a string sql
   *
   * @return void
   */
  protected static function mountSQL()
  {
    $shortname = self::$shortname? (" AS " . self::$shortname): '';
    //
    $where = implode(' AND ', self::$where);
    $where = $where ? "WHERE {$where}" : '';
    //
    $update = implode(', ', self::$update);
    $update = $update ? "SET {$update}" : '';
    //
    $join = implode(' ', self::$join) ?? '';
    //
    self::$sql = sprintf("%s %s %s %s %s %s %s %s", self::$command, self::$columns, self::$from, self::$tableName, $shortname, $update, $join, $where, self::$order, self::$limit);
    self::$sql = preg_replace('/\s+/', ' ', self::$sql);
  }

  /**
   * Fetch do PDO
   *
   * @return void
   */
  protected static function fetch()
  {
    self::finalize();
    self::bindParams();
    self::$stmt->execute();
    return self::$stmt->fetch();
  }

  /**
   * FetchAll do PDO
   *
   * @return array
   */
  protected static function fetchAll(): array
  {
    self::finalize();
    self::bindParams();
    self::$stmt->execute();
    return self::$stmt->fetchAll();
  }

  /**
   * Passa os parâmetros do PDO
   *
   * @return void
   */
  protected static function bindParams()
  {
    foreach (self::$data as $key => $value) {
      self::$stmt->bindParam($key, $value);
    }
  }

  /**
   * Monta e retorna a conexão atual
   *
   * @param string $name
   * @return PDO
   */
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

  /**
   * Retorna um erro no banco
   *
   * @param [type] $message
   * @return void
   */
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
