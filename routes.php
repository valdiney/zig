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

$route->route('HomeController', 'index', $logged);

# ----- UsuarioController --------------------------------
$route->route('UsuarioController', 'index',  $logged);
$route->route('UsuarioController', 'save',   $logged);
$route->route('UsuarioController', 'modal',  $logged);
$route->route('UsuarioController', 'update', $logged);

# ----- VendaController --------------------------------
$route->route('VendaController', 'index', $logged);
$route->route('VendaController', 'save', $logged);
$route->route('VendaController', 'colocarProdutosNaMesa',  $logged);
$route->route('VendaController', 'obterProdutosDaMesa',  $logged);
$route->route('VendaController', 'alterarAquantidadeDeUmProdutoNaMesa',  $logged);
$route->route('VendaController', 'retirarProdutoDaMesa',  $logged);

$route->route('VendaController', 'saveVendasViaSession',  $logged);
$route->route('VendaController', 'obterValorTotalDosProdutosNaMesa',  $logged);
$route->route('VendaController', 'teste',  $logged);

# ----- RelatorioController --------------------------------
$route->route('RelatorioController', 'index',  $logged);
$route->route('RelatorioController', 'vendasPorPeriodo',  $logged);
$route->route('RelatorioController', 'vendasChamadaAjax',  $logged);

# ----- ProdutoController --------------------------------
$route->route('ProdutoController', 'index',  $logged);
$route->route('ProdutoController', 'modalFormulario',  $logged);
$route->route('ProdutoController', 'save',  $logged);
$route->route('ProdutoController', 'update',  $logged);
