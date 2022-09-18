<?php

use System\CommandLine\Migrate;
use System\Route\GetRoute;
use System\Route\SelectController;

$method = $_SERVER['REQUEST_METHOD'];

# Load controllers
new SelectController(new GetRoute);

$timezones = array(
  'AC - America/Rio_branco',
  'AL - America/Maceio',
  'AP - America/Belem',
  'AM - America/Manaus',
  'BA - America/Bahia',
  'CE - America/Fortaleza',
  'DF - America/Sao_Paulo',
  'ES - America/Sao_Paulo',
  'GO - America/Sao_Paulo',
  'MA - America/Fortaleza',
  'MT - America/Cuiaba',
  'MS - America/Campo_Grande',
  'MG - America/Sao_Paulo',
  'PR - America/Sao_Paulo',
  'PB - America/Fortaleza',
  'PA - America/Belem',
  'PE - America/Recife',
  'PI - America/Fortaleza',
  'RJ - America/Sao_Paulo',
  'RN - America/Fortaleza',
  'RS - America/Sao_Paulo',
  'RO - America/Porto_Velho',
  'RR - America/Boa_Vista',
  'SC - America/Sao_Paulo',
  'SE - America/Maceio',
  'SP - America/Sao_Paulo',
  'TO - America/Araguaia',
);

if ($method === 'GET') {
  require_once(__DIR__.'/install/index.php');
  exit;
}

// post

$data = [];

$data['APP_ENV']            = $_POST['APP_ENV'] ?? 'local';
$data['APP_DISPLAY_ERRORS'] = isset($_POST['APP_DISPLAY_ERRORS']) && $_POST['APP_DISPLAY_ERRORS']==='on'? 'true': 'false';
$data['HTTPS']              = isset($_POST['APP_HTTPS']) && $_POST['APP_HTTPS']==='on'? 'true': 'false';

$data['TIMEZONE'] = $_POST['APP_TIMEZONE'] ?? 4; // bahia como default
$data['TIMEZONE'] = $timezones[$data['TIMEZONE']];
$data['TIMEZONE'] = explode(' - ', $data['TIMEZONE']);
$data['TIMEZONE'] = end($data['TIMEZONE']);

$data['HOST_NAME']     = $_POST['HOST_NAME'] ?? null;
$data['HOST_USERNAME'] = $_POST['HOST_USERNAME'] ?? null;
$data['HOST_PASSWORD'] = $_POST['HOST_PASSWORD'] ?? null;
$data['HOST_DBNAME']   = $_POST['HOST_DBNAME'] ?? null;

$data['MAIL_HOST']     = $_POST['MAIL_HOST'] ?? null;
$data['MAIL_PORT']     = $_POST['MAIL_PORT'] ?? null;
$data['MAIL_USERNAME'] = $_POST['MAIL_USERNAME'] ?? null;
$data['MAIL_PASSWORD'] = $_POST['MAIL_PASSWORD'] ?? null;

$config = "";

foreach ($data as $key => $value) {
  $index = array_search($key, array_keys($data));
  $config .= "{$key}={$value}\n";
}

$envPath = __DIR__ . '/../../.env';

file_put_contents($envPath, $config);

new Migrate();

header("Refresh: 0.5");

