<?php

namespace System\CommandLine;

use Exception;
use System\Model\Model;

class Migrate extends Model
{
  protected $migrationPath = "/../../Database/migrations/";
  protected $migrationsCode = [1593604775,1593605007,1593605094,1593605143,1593605239,1593605328,1593605367,1593605428,1593605466,1593605510,1593605548,1593605570,1593605592,1593605596,1593605654,1593605683,1593608384];

  public function __construct()
  {
    parent::__construct();
    //
    try {
      $tables = $this->query("SHOW TABLES");
    } catch(Exception $e) {
      echo "Algo deu errado!\n";
      dd($e->getMessage());
    }
    //
    $this->verifyIfTableMigrationExists($tables);
    //
    $this->migrate();
  }

  public function verifyIfTableMigrationExists(array $tables)
  {
    $tableExists = false;
    foreach ($tables as $table) {
      $array      = get_object_vars($table);
      $properties = array_values($array);
      $name       = $properties[0];
      if ($name == 'migrations') {
        $tableExists = true;
      }
    }
    if ($tableExists == false) {
      $this->createTableMigrations();
    }
  }

  public function createTableMigrations()
  {
    $migrationsCode = implode('|', $this->migrationsCode);
    $migrationsCode = "({$migrationsCode})";
    //
    $files = glob(__DIR__ . "{$this->migrationPath}*.sql");
    $files = array_filter($files, function ($file) use($migrationsCode) {
      return preg_match("/(.*)\/{$migrationsCode}_(.*)/", $file) == true;
    });
    $this->migrateRun($files, false);
  }

  public function migrate()
  {
    $migrations = $this->query("SELECT code FROM migrations WHERE id > 1");
    foreach($migrations as &$migration) {
      $migration = $migration->code;
    }
    $migrationsCode = implode('|',$migrations);
    $migrationsCode = "({$migrationsCode})";
    //
    $files = glob(__DIR__ . "{$this->migrationPath}*.sql");
    array_shift($files);
    $files = array_filter($files, function($file) use($migrationsCode) {
      return preg_match("/(.*)\/{$migrationsCode}_(.*)/", $file) == false;
    });
    if (count($files)) {
      $this->migrateRun($files);
      echo "Tabelas migradas com sucesso! ;)\n";
      return;
    }
    echo "Não havia nada para migrar!\n";
  }

  public function migrateRun($files, $addToMigrations = true)
  {
    foreach($files as $file) {
      $data = pathinfo($file, PATHINFO_FILENAME);
      $code = explode('_', $data);
      $code = current($code);
      $description = trim(str_replace(['_',$code], [' ',''], $data));
      //
      echo "- {$description} \n";
      $content = file_get_contents($file);
      $this->query($content, false);
      // se true adiciona a nova migração à tabela migrations
      if ($addToMigrations) {
        $this->insert("INSERT INTO migrations (code, description) VALUES (?,?)", [$code,$description]);
      }
    }
  }
}
