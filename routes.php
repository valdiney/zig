<?php
/*-----------------------------------------------------
* Declaração das rotas do Sistema
*/
use App\Rules\Logged;

# ----- LoginController --------------------------------
$route->create('/', 'LoginController@index');
$route->create('login/index', 'LoginController@index');
$route->create('login/logar', 'LoginController@logar');
$route->create('login/logout', 'LoginController@logout');

$route->create('home/index', 'HomeController@index');

# ----- UsuarioController --------------------------------
$route->create('usuario/index', 'UsuarioController@index');
$route->create('usuario/save', 'UsuarioController@save');
$route->create('usuario/modal', 'UsuarioController@modal');
$route->create('usuario/update', 'UsuarioController@update');

# ----- RelatorioController --------------------------------
$route->create('relatorio/index', 'RelatorioController@index');
$route->create('relatorio/vendasPorPeriodo', 'RelatorioController@vendasPorPeriodo');
$route->create('relatorio/vendasChamadaAjax', 'RelatorioController@vendasChamadaAjax');

# ----- ProdutoController --------------------------------
$route->create('produto/index', 'ProdutoController@index');
$route->create('produto/modalFormulario', 'ProdutoController@modalFormulario');
$route->create('produto/save', 'ProdutoController@save');
$route->create('produto/update', 'ProdutoController@update');

# ----- ConfiguracaoController --------------------------------
$route->create('configuracao/index', 'ConfiguracaoController@index');
$route->create('configuracao/alterarConfigPdv', 'ConfiguracaoController@alterarConfigPdv');

# ----- PdvPadraoController  --------------------------------
$route->create('pdvPadrao/index', 'PdvPadraoController@index');
$route->create('pdvPadrao/save', 'PdvPadraoController@save');

# ----- PdvDiferencialController  --------------------------------
$route->create('pdvDiferencial/index', 'PdvDiferencialController@index');
$route->create('pdvDiferencial/colocarProdutosNaMesa', 'PdvDiferencialController@colocarProdutosNaMesa');
$route->create('pdvDiferencial/obterProdutosDaMesa', 'PdvDiferencialController@obterProdutosDaMesa');

$route->create('pdvDiferencial/alterarAquantidadeDeUmProdutoNaMesa', 'PdvDiferencialController@alterarAquantidadeDeUmProdutoNaMesa');

$route->create('pdvDiferencial/retirarProdutoDaMesa', 'PdvDiferencialController@retirarProdutoDaMesa');
$route->create('pdvDiferencial/saveVendasViaSession', 'PdvDiferencialController@saveVendasViaSession');

$route->create('pdvDiferencial/obterValorTotalDosProdutosNaMesa', 'PdvDiferencialController@obterValorTotalDosProdutosNaMesa');

# ----- ClienteController --------------------------------
$route->create('cliente/index', 'ClienteController@index');
$route->create('cliente/modalFormulario', 'ClienteController@modalFormulario');
$route->create('cliente/save', 'ClienteController@save');
$route->create('cliente/update', 'ClienteController@update');

$route->create('cliente/verificaSeEmailExiste', 'ClienteController@verificaSeEmailExiste');
$route->create('cliente/verificaSeCnpjExiste', 'ClienteController@verificaSeCnpjExiste');
$route->create('cliente/verificaSeCpfExiste', 'ClienteController@verificaSeCpfExiste');

# ----- EnderecoController --------------------------------
$route->create('clienteEndereco/index', 'ClienteEnderecoController@index');
$route->create('clienteEndereco/save', 'ClienteEnderecoController@save');
$route->create('clienteEndereco/update', 'ClienteEnderecoController@update');
$route->create('clienteEndereco/modalFormulario', 'ClienteEnderecoController@modalFormulario');

# ----- PedidoController --------------------------------
$route->create('pedido/index', 'PedidoController@index');

# Run Router
$route->run();