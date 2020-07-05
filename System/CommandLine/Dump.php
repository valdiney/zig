<?php

namespace System\CommandLine;

use Exception;
use System\Model\Model;

class Dump extends Model
{
  protected $dumpPath = "/../../Database/dump/";

  public function __construct()
  {
    parent::__construct();
    //
    try {
      $this->query("SHOW TABLES");
    } catch(Exception $e) {
      echo "Verifique o seu banco de dados!";
      dd($e->getMessage());
    }
    //
    $this->dump();
  }

  public function dump()
  {
    $files = glob(__DIR__ . "{$this->dumpPath}*.sql");
    if (count($files)) {
      $this->dumpRun($files);
      echo "Tabelas populadas com sucesso! ;)\n";
      return;
    }
    echo "Não havia nada para inserir!\n";
  }

  public function dumpRun($files)
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
    }
  }
}
