<?php

namespace System\CommandLine;

class Command
{
  protected $arguments = [];
  protected $argumentClass = null;
  protected $argumentsList = [
    'help' => 'System\CommandLine\Help'
  ];

  public function run(array $args)
  {
    if (!count($args)) {
      $args = ['help'];
    }
    $this->arguments = $args;
    $this->argumentClass = $args[0];
    if (!isset($this->argumentsList[$this->argumentClass])) {
      echo "O comando não existe.";
      exit(0);
    }
    $this->argumentClass = $this->argumentsList[$this->argumentClass];
    $this->argumentClass = new $this->argumentClass;
  }

}
