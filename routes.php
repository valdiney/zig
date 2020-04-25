<?php
/*-----------------------------------------------------
* Declaração das rotas do Sistema
*/
use App\Rules\Logged;

$route->index('LoginController', "index");
$route->route('LoginController', "logar");
$route->route('LoginController', "logout");

$logged = new Logged();


$route->route('HomeController', 'index', $logged);
$route->route('VendaController', 'index', $logged);
$route->route('VendaController', 'save', $logged);

# ----- UsuarioController --------------------------------
$route->route('UsuarioController', 'index',  $logged);
$route->route('UsuarioController', 'save',   $logged);
$route->route('UsuarioController', 'modal',  $logged);
$route->route('UsuarioController', 'update', $logged);