<?php

namespace System\CommandLine\Create;

class Dump
{
  protected $path = 'Database/dump/';
  protected $fullPath = '/../../../';

  public function __construct(array $args) {
    if (!isset($args[0])) {
      echo "É necessário passar o nome do dump!\n";
      exit(0);
    }
    $name = implode(' ', $args);
    $name = strtolower($name);
    $filename = time() .'_'. str_replace(' ', '_', $name) . '.sql';
    $path = $this->path . $filename;
    $fullPath = __DIR__ . $this->fullPath . $path;
    file_put_contents($fullPath, '');
    echo "Dump criada com sucesso!\n";
    echo "➜ {$path}";
  }
}
