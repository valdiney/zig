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
$route->get('usuario/modalFormulario/{idUsuario?}', 'UsuarioController@modalFormulario');
$route->post('usuario/update', 'UsuarioController@update');

$route->get('usuario/teste', 'UsuarioController@testeEmail');

# ----- RelatorioController --------------------------------
$route->get('relatorio', 'RelatorioController@index');
$route->get('relatorio/vendasPorPeriodo', 'RelatorioController@vendasPorPeriodo');
$route->post('relatorio/vendasChamadaAjax', 'RelatorioController@vendasChamadaAjax');
$route->get('relatorio/gerarXls', 'RelatorioController@gerarXls');
$route->get('relatorio/gerarPDF', 'RelatorioController@gerarPDF');

# ----- ProdutoController --------------------------------
$route->get('produto', 'ProdutoController@index');
$route->get('produto/modalFormulario/{idProduto?}', 'ProdutoController@modalFormulario');
$route->post('produto/save', 'ProdutoController@save');
$route->post('produto/update', 'ProdutoController@update');

# ----- ConfiguracaoController --------------------------------
$route->get('configuracao', 'ConfiguracaoController@index');
$route->post('configuracao/alterarConfigPdv', 'ConfiguracaoController@alterarConfigPdv');

# ----- PdvPadraoController  --------------------------------
$route->get('pdvPadrao', 'PdvPadraoController@index');
$route->post('pdvPadrao/save', 'PdvPadraoController@save');

# ----- PdvDiferencialController  --------------------------------
$route->get('pdvDiferencial', 'PdvDiferencialController@index');
$route->get('pdvDiferencial/colocarProdutosNaMesa/{idProduto}', 'PdvDiferencialController@colocarProdutosNaMesa');
$route->get('pdvDiferencial/obterProdutosDaMesa/{posicaoProduto?}', 'PdvDiferencialController@obterProdutosDaMesa');

$route->get('pdvDiferencial/alterarAquantidadeDeUmProdutoNaMesa/{idProduto}/{quantidade}',
  'PdvDiferencialController@alterarAquantidadeDeUmProdutoNaMesa');

$route->get('pdvDiferencial/retirarProdutoDaMesa/{idProduto}', 'PdvDiferencialController@retirarProdutoDaMesa');
$route->post('pdvDiferencial/saveVendasViaSession', 'PdvDiferencialController@saveVendasViaSession');

$route->get('pdvDiferencial/obterValorTotalDosProdutosNaMesa',
  'PdvDiferencialController@obterValorTotalDosProdutosNaMesa');

# ----- ClienteController --------------------------------
$route->get('cliente', 'ClienteController@index');
$route->get('cliente/modalFormulario/{idCliente?}', 'ClienteController@modalFormulario');
$route->post('cliente/save', 'ClienteController@save');
$route->post('cliente/update', 'ClienteController@update');
$route->get('cliente/desativarCliente/{idCliente}', 'ClienteController@desativarCliente');
$route->get('cliente/ativarCliente/{idCliente}', 'ClienteController@ativarCliente');

$route->get('cliente/verificaSeEmailExiste/{email}/{idCliente?}', 'ClienteController@verificaSeEmailExiste');
$route->get('cliente/verificaSeCnpjExiste/{cnpj}/{idCliente?}', 'ClienteController@verificaSeCnpjExiste');
$route->get('cliente/verificaSeCpfExiste/{cpf}/{idCliente?}', 'ClienteController@verificaSeCpfExiste');

# ----- EnderecoController --------------------------------
$route->get('clienteEndereco/index/{idCliente}', 'ClienteEnderecoController@index');
$route->post('clienteEndereco/save', 'ClienteEnderecoController@save');
$route->post('clienteEndereco/update', 'ClienteEnderecoController@update');
$route->get('clienteEndereco/modalFormulario/{idCliente}/{idEnderecoCliente?}',
  'ClienteEnderecoController@modalFormulario');
$route->get('clienteEndereco/buscarEnderecoViaCep/{cep?}', 'ClienteEnderecoController@buscarEnderecoViaCep');

# ----- PedidoController --------------------------------
$route->get('pedido', 'PedidoController@index');

$route->get('pwa/login', 'Api\InicioPwaController@index');
$route->post('pwa/logar', 'Api\LoginController@logar');
$route->get('pwa/pdv', 'Api\InicioPwaController@pdv');

# ----- LogController --------------------------------
$route->get('logs', 'LogAcessoController@index');

# ----- EmpresaController --------------------------------
$route->get('empresa', 'EmpresaController@index');
$route->post('empresa/save', 'EmpresaController@save');
$route->post('empresa/update', 'EmpresaController@update');
$route->get('empresa/modalFormulario/{idEmpresa?}', 'EmpresaController@modalFormulario');

# Router run
$route->run();
