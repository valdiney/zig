<?php 
header('Access-Control-Allow-Origin: *');
header('Content-type: text/html; charset=UTF-8');

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

date_default_timezone_set('America/Bahia');
require_once(__DIR__ . '/vendor/autoload.php');

use System\Route\GetRoute;
use System\Route\SelectController;

# Load env configuration
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

# Load controllers
$route = new SelectController(new GetRoute);

session_start();

# Load routes
require_once(__DIR__ . '/routes.php');