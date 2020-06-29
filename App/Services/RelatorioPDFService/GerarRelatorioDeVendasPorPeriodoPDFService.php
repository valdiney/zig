<?php 
namespace App\Services\RelatorioPDFService;

use Dompdf\Dompdf;

class GerarRelatorioDeVendasPorPeriodoPDFService
{
	protected $titulo;
	protected $nomeDoArquivo;
	protected $diretorio;
	protected $periodo = [];

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	public function setNomeDoArquivo($nomeDoArquivo)
	{
		$this->nomeDoArquivo = $nomeDoArquivo.'.pdf';
	}

	public function setPeriodo(array $periodo)
	{
		$this->periodo = $periodo;
	}

	public function setDiretorio($diretorio)
	{
		$this->diretorio = $diretorio;
	}

	public function gerarPDF($vendas)
	{
    $titulo = "Relatório de vendas por período.{$this->periodo['de']} à {$this->periodo['ate']}";
    $head = [
      'Usuário',
      'preço',
      'Quantidade',
      'Total',
      'Meio Pagamento',
      'Hora',
      'Data'
    ];
    $dados = [];
    foreach ($vendas as $venda) {
      $dados[] = [
        $venda->nomeUsuario,
        ($venda->preco != 0) ? 'R$ ' . number_format($venda->preco, 2, ',', '.') : 'Não consta',
        (!is_null($venda->quantidade)) ? $venda->quantidade : 'Não consta',
        'R$ ' . number_format($venda->valor, 2, ',', '.'),
        $venda->legenda,
        $venda->hora,
        $venda->data
      ];
    }
    //
    $dompdf = new Dompdf();
    // $dompdf->setPaper('A4', 'landscape');
    $file = __DIR__.'/../../Views/relatorio/relatorioPDF.php';
    define("DOMPDF_ENABLE_PHP", true);
    $dompdf->set_option('chroot', $file);
    // $file = file_get_contents($file);
    ob_start();
    include($file);
    $file = ob_get_clean();
    $dompdf->load_html($file);
    // download
    $dompdf->render();
    // renderiza no navegador
    // $dompdf->stream($this->nomeDoArquivo, array("Attachment" => false));
    // salva arquivo
    return $dompdf->stream($this->nomeDoArquivo);
    exit(0);
	}
}
