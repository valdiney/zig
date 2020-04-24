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



# ----- UsuarioController --------------------------------
$route->route('UsuarioController', 'index',  $logged);
$route->route('UsuarioController', 'save',   $logged);
$route->route('UsuarioController', 'modal',  $logged);
$route->route('UsuarioController', 'update', $logged);

# ----- ProjetoController --------------------------------
$route->route('ProjetoController', 'index',  $logged);
$route->route('ProjetoController', 'modal',  $logged);
$route->route('ProjetoController', 'save',   $logged);
$route->route('ProjetoController', 'update', $logged);

# ----- TicketController --------------------------------
$route->route('TicketController', 'index',  $logged);
$route->route('TicketController', 'save',   $logged);
$route->route('TicketController', 'update', $logged);
$route->route('TicketController', 'modal',  $logged);
$route->route('TicketController', 'atribuirUsuarioViaAjax',  $logged);
$route->route('TicketController', 'ticket', $logged);
