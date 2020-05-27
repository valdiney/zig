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

# ----- RelatorioController --------------------------------
$route->route('RelatorioController', 'index',  $logged);
$route->route('RelatorioController', 'vendasPorPeriodo',  $logged);
$route->route('RelatorioController', 'vendasChamadaAjax',  $logged);

# ----- ProdutoController --------------------------------
$route->route('ProdutoController', 'index',  $logged);
$route->route('ProdutoController', 'modalFormulario',  $logged);
$route->route('ProdutoController', 'save',  $logged);
$route->route('ProdutoController', 'update',  $logged);

# ----- ConfiguracaoController --------------------------------
$route->route('ConfiguracaoController', 'index',  $logged);
$route->route('ConfiguracaoController', 'alterarConfigPdv',  $logged);

# ----- PdvPadraoController  --------------------------------
$route->route('PdvPadraoController', 'index',  $logged);
$route->route('PdvPadraoController', 'save',  $logged);

# ----- PdvDiferencialController  --------------------------------
$route->route('PdvDiferencialController', 'index',  $logged);
$route->route('PdvDiferencialController', 'colocarProdutosNaMesa',  $logged);
$route->route('PdvDiferencialController', 'obterProdutosDaMesa',  $logged);
$route->route('PdvDiferencialController', 'alterarAquantidadeDeUmProdutoNaMesa',  $logged);
$route->route('PdvDiferencialController', 'retirarProdutoDaMesa',  $logged);
$route->route('PdvDiferencialController', 'saveVendasViaSession',  $logged);
$route->route('PdvDiferencialController', 'obterValorTotalDosProdutosNaMesa',  $logged);

# ----- ClienteController --------------------------------
$route->route('ClienteController', 'index',  $logged);

# ----- PedidoController --------------------------------
$route->route('PedidoController', 'index',  $logged);