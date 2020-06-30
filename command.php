<?php

define('IS_TERMINAL', true);

require_once('./vendor/autoload.php');

$command = new System\CommandLine\Command;

$args = array_slice($argv, 1);

$command->run($args);
