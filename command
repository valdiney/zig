#!/usr/bin/env php
<?php

define('IS_TERMINAL', true);

require_once('./vendor/autoload.php');

# Load env configuration
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$command = new System\CommandLine\Command;

$args = array_slice($argv, 1);

$command->run($args);
