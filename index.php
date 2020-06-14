<?php 
header('Access-Control-Allow-Origin: *');
header('Content-type: text/html; charset=UTF-8');

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

// 43200 sessão ativa por 12h
ini_set('session.cookie_lifetime', 43200);
ini_set('session.cache_expire', 43200);
ini_set('session.gc_maxlifetime', 43200);

session_start();

date_default_timezone_set('America/Bahia');
require_once(__DIR__ . '/vendor/autoload.php');

use System\Route\GetRoute;
use System\Route\SelectController;

# Load env configuration
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

# Load controllers
$route = new SelectController(new GetRoute);

# Load routes
require_once(__DIR__ . '/routes.php');