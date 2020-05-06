<?php
/*-----------------------------------------------------
* Declaração das rotas do Sistema
*/
use App\Rules\Logged;

# ----- LoginController --------------------------------
$route->index('LoginController', "index");
$route->route('LoginController', "logar");
$route->route('LoginController', "logout");

$logged = new Logged();

# ----- UsuarioController --------------------------------
$route->route('UsuarioController', 'index',  $logged);
$route->route('UsuarioController', 'save',   $logged);
$route->route('UsuarioController', 'modal',  $logged);
$route->route('UsuarioController', 'update', $logged);

# ----- VendaController --------------------------------
$route->route('HomeController', 'index', $logged);
$route->route('VendaController', 'index', $logged);
$route->route('VendaController', 'save', $logged);

# ----- RelatorioController --------------------------------
$route->route('RelatorioController', 'index',  $logged);