<?php 
namespace App\Services\RelatorioXlsService;

class GerarRelatorioDeVendasPorPeriodoXlsService
{
	protected $titulo;
	protected $nomeDoArquivo;

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	public function setNomeDoArquivo($nomeDoArquivo)
	{
		$this->nomeDoArquivo = $nomeDoArquivo.'.xls';
	}

	public function gerarXsl($vendas)
	{
		$html = '';
		$html .= "<table border='1'>
		<tr><td colspan='4' bgcolor='#f4f3ef'>{$this->titulo}</tr>
		<tr>
    		<td><b>Valor</b></td>
    		<td><b>Pagamento</b></td>
    		<td><b>Hora</b></td>
    		<td><b>Data</b></td>
		</tr>";

		foreach($vendas as $venda) {
			$valorVenda = number_format($venda->valor, 2,',','.');
			$html .= "<tr>
				<td>R$ {$valorVenda}</td>
				<td>{$venda->legenda}</td>
				<td>{$venda->hora}h</td>
				<td>{$venda->data}</td>
			</tr>";
	    }

	    $html .= "</table>";

	    $this->headers();
	    echo $html;
	}

	private function headers()
	{
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$this->nomeDoArquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
	}
}
