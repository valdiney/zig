<?php

namespace System\CommandLine\Create;

class Controller
{
  protected $createModelsPath = '/Models/Controller.php';
  protected $controllerPath = '/../../../App/Controllers/';

  public function __construct(array $args) {
    if (!isset($args[0])) {
      echo "É necessário passar o nome do controller!\n";
      exit(0);
    }
    $controllerName = $args[0];
    // certifica de que foi  passado Controller no nome
    $controllerName = preg_replace('/(.*)Controller$/', "$1", $controllerName);
    $controllerPath = $controllerName;
    $controllerName = "{$controllerName}Controller";
    // gera classe
    $content = file_get_contents(__DIR__ . $this->createModelsPath);
    //
    if (strpos($controllerName, '/')) {
      $namespace = pathinfo($controllerName, PATHINFO_DIRNAME);
      $dirname = __DIR__ . $this->controllerPath . $namespace;
      $namespace = str_replace('/','\\', $namespace);
      $content = str_replace('namespace App\Controllers;', "namespace App\Controllers\\{$namespace};", $content);
      $controllerName = pathinfo($controllerName, PATHINFO_FILENAME);
      $controllerPath = "{$namespace}/{$controllerName}";
      $controllerPath = str_replace('\\', '/', $controllerPath);
      mkdir($dirname, 0777, true);
    }
    $content = str_replace('_ClassName_', $controllerName, $content);
    // salva arquivo
    $filename = __DIR__ . "{$this->controllerPath}{$controllerPath}.php";
    if (file_exists($filename)) {
      echo "O controller já existe!\n";
      exit(0);
    }
    file_put_contents($filename, $content);
  }
}
