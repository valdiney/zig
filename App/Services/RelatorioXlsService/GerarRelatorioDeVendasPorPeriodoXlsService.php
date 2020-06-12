<?php 
namespace App\Services\RelatorioXlsService;

class GerarRelatorioDeVendasPorPeriodoXlsService
{
	protected $titulo;
	protected $nomeDoArquivo;
	protected $periodo = [];

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	public function setNomeDoArquivo($nomeDoArquivo)
	{
		$this->nomeDoArquivo = $nomeDoArquivo.'.xls';
	}

	public function setPeriodo(array $periodo)
	{
		$this->periodo = $periodo;
	}

	public function gerarXsl($vendas)
	{
		$legendaUsuario = utf8_decode('Usuário');
		$html = '';
		$html .= "<table border='1'>
		<tr>
		<td colspan='5' bgcolor='#f4f3ef' style='background:black;color:white;'>
		  
		</tr>
		<td colspan='5' bgcolor='#f4f3ef' style='background:black;color:#d5d3d3;'>
		    <center><b>{$this->titulo}</b></center>
		</tr>
		<td colspan='5' bgcolor='#f4f3ef' style='background:black;color:white;'>
		    
		</tr>
		<tr>
		    <td bgcolor='#669966' style='color:white'>{$legendaUsuario}</td>
    		<td bgcolor='#669966' style='color:white'><b>Valor</b></td>
    		<td bgcolor='#669966' style='color:white'><b>Pagamento</b></td>
    		<td bgcolor='#669966' style='color:white'><b>Hora</b></td>
    		<td bgcolor='#669966' style='color:white'><b>Data</b></td>
		</tr>";

		foreach($vendas as $venda) {
			$usuario = utf8_decode($venda->nome);
			$valorVenda = number_format($venda->valor, 2,',','.');
			$tipoDePagamento = utf8_decode($venda->legenda);
			$html .= "<tr>
			    <td>{$usuario}</td>
				<td bgcolor='#fffcf5'>R$ {$valorVenda}</td>
				<td>{$tipoDePagamento}</td>
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
		header( "Content-type: application/vnd.ms-excel; charset=UTF-8");
		header ("Content-Disposition: attachment; filename=\"{$this->nomeDoArquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
	}
}
