<?php

namespace System\CommandLine\Create;

class Migration
{
  protected $path = 'Database/migrations/';
  protected $fullPath = '/../../../';

  public function __construct(array $args) {
    if (!isset($args[0])) {
      echo "É necessário passar o nome da migration!\n";
      exit(0);
    }
    $name = implode(' ', $args);
    $name = strtolower($name);
    $filename = time() .'_'. str_replace(' ', '_', $name) . '.sql';
    $path = $this->path . $filename;
    $fullPath = __DIR__ . $this->fullPath . $path;
    file_put_contents($fullPath, '');
    echo "Migration criada com sucesso! Você já pode adicionar o conteúdo a ela!\n";
    echo "➜ {$path}";
  }
}
