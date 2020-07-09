<?php
/*-----------------------------------------------------
* Declaração das rotas do Sistema
*/

# ----- LoginController --------------------------------
$route->get('/', 'LoginController@index');
$route->get('login', 'LoginController@index');
$route->post('login/logar', 'LoginController@logar');
$route->get('login/logout', 'LoginController@logout');

$route->get('home', 'HomeController@index');

# ----- UsuarioController --------------------------------
$route->get('usuario', 'UsuarioController@index');
$route->post('usuario/save', 'UsuarioController@save');
$route->get('usuario/modal', 'UsuarioController@modal');
$route->post('usuario/update', 'UsuarioController@update');

# ----- RelatorioController --------------------------------
$route->get('relatorio', 'RelatorioController@index');
$route->get('relatorio/vendasPorPeriodo', 'RelatorioController@vendasPorPeriodo');
$route->post('relatorio/vendasChamadaAjax', 'RelatorioController@vendasChamadaAjax');
$route->get('relatorio/gerarXls', 'RelatorioController@gerarXls');
$route->get('relatorio/gerarPDF', 'RelatorioController@gerarPDF');

# ----- ProdutoController --------------------------------
$route->get('produto', 'ProdutoController@index');
$route->get('produto/modalFormulario', 'ProdutoController@modalFormulario');
$route->post('produto/save', 'ProdutoController@save');
$route->post('produto/update', 'ProdutoController@update');

# ----- ConfiguracaoController --------------------------------
$route->get('configuracao', 'ConfiguracaoController@index');
$route->post('configuracao/alterarConfigPdv', 'ConfiguracaoController@alterarConfigPdv');

# ----- PdvPadraoController  --------------------------------
$route->get('pdvPadrao', 'PdvPadraoController@index');
$route->get('pdvPadrao/save', 'PdvPadraoController@save');

# ----- PdvDiferencialController  --------------------------------
$route->get('pdvDiferencial', 'PdvDiferencialController@index');
$route->get('pdvDiferencial/colocarProdutosNaMesa', 'PdvDiferencialController@colocarProdutosNaMesa');
$route->get('pdvDiferencial/obterProdutosDaMesa', 'PdvDiferencialController@obterProdutosDaMesa');

$route->get('pdvDiferencial/alterarAquantidadeDeUmProdutoNaMesa', 'PdvDiferencialController@alterarAquantidadeDeUmProdutoNaMesa');

$route->get('pdvDiferencial/retirarProdutoDaMesa', 'PdvDiferencialController@retirarProdutoDaMesa');
$route->get('pdvDiferencial/saveVendasViaSession', 'PdvDiferencialController@saveVendasViaSession');

$route->get('pdvDiferencial/obterValorTotalDosProdutosNaMesa', 'PdvDiferencialController@obterValorTotalDosProdutosNaMesa');

# ----- ClienteController --------------------------------
$route->get('cliente', 'ClienteController@index');
$route->get('cliente/modalFormulario', 'ClienteController@modalFormulario');
$route->post('cliente/save', 'ClienteController@save');
$route->post('cliente/update', 'ClienteController@update');
$route->get('cliente/desativarCliente', 'ClienteController@desativarCliente');
$route->get('cliente/ativarCliente', 'ClienteController@ativarCliente');

$route->get('cliente/verificaSeEmailExiste', 'ClienteController@verificaSeEmailExiste');
$route->get('cliente/verificaSeCnpjExiste', 'ClienteController@verificaSeCnpjExiste');
$route->get('cliente/verificaSeCpfExiste', 'ClienteController@verificaSeCpfExiste');

# ----- EnderecoController --------------------------------
$route->get('clienteEndereco/{any}', 'ClienteEnderecoController@index');
$route->post('clienteEndereco/save', 'ClienteEnderecoController@save');
$route->post('clienteEndereco/update', 'ClienteEnderecoController@update');
$route->get('clienteEndereco/modalFormulario', 'ClienteEnderecoController@modalFormulario');
$route->get('clienteEndereco/buscarEnderecoViaCep', 'ClienteEnderecoController@buscarEnderecoViaCep');

# ----- PedidoController --------------------------------
$route->get('pedido', 'PedidoController@index');

$route->get('pwa/login', 'Api\InicioPwaController@index');
$route->post('pwa/logar', 'Api\LoginController@logar');
$route->get('pwa/pdv', 'Api\InicioPwaController@pdv');

# ----- LogController --------------------------------
$route->get('logs', 'LogAcessoController@index');

# ----- PermissaoController --------------------------------
$route->get('usuario/permissoes', 'UsuarioModuloController@index');
$route->get('usuario/salvarPermissoes', 'UsuarioModuloController@salvarPermissoes');

# ----- EmpresaController --------------------------------
$route->get('empresa', 'EmpresaController@index');
$route->post('empresa/save', 'EmpresaController@save');
$route->post('empresa/update', 'EmpresaController@update');
$route->get('empresa/modalFormulario', 'EmpresaController@modalFormulario');

# Router run
$route->run();
