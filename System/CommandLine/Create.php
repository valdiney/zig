<?php

namespace System\CommandLine;

class Create
{
  protected $argumentClass = null;
  protected $argumentsList = [
    'controller' => 'System\CommandLine\Create\Controller',
    'migration'  => 'System\CommandLine\Create\Migration',
    'dump'       => 'System\CommandLine\Create\Dump',
  ];

  public function __construct(array $args)
  {
    $this->argumentClass = $args[0];
    if (!isset($this->argumentsList[$this->argumentClass])) {
      echo "O comando não existe dentro de create!\n";
      exit(0);
    }
    array_shift($args);
    $this->argumentClass = $this->argumentsList[$this->argumentClass];
    $this->argumentClass = new $this->argumentClass($args);
  }
}
