<?php

namespace System\CommandLine;

class Command
{
  protected $arguments = [];
  protected $argumentClass = null;
  protected $argumentsList = [
    'help'    => 'System\CommandLine\Help',
    'create'  => 'System\CommandLine\Create',
    'migrate' => 'System\CommandLine\Migrate',
    'dump'    => 'System\CommandLine\Dump',
    'hash'    => 'System\CommandLine\Hash',
  ];

  public function run(array $args)
  {
    if (!count($args)) {
      $args = ['help'];
    }
    $this->arguments = $args;
    $this->argumentClass = $args[0];
    if (!isset($this->argumentsList[$this->argumentClass])) {
      echo "O comando não existe!\n";
      exit(0);
    }
    // remove first index
    array_shift($args);
    $this->argumentClass = $this->argumentsList[$this->argumentClass];
    $this->argumentClass = new $this->argumentClass($args);
  }

}
