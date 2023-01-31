<?php

namespace App\Services\RelatorioPDFService;
use Dompdf\Dompdf;

class RelatorioPdfDeUmaVenda
{
    protected $nomeEmpresa;

    public function setNomeEmpresa($nomeEmpresa)
    {
        $this->nomeEmpresa = $nomeEmpresa;
    }

    public function gerarPDF($dadosVenda, $informacaoPagamento)
    {
        $this->domPdfConfig($dadosVenda, $informacaoPagamento);
    }

    protected function domPdfConfig($dadosVenda, $informacaoPagamento)
    {
        $nomeEmpresa = $this->nomeEmpresa;

        $dompdf = new Dompdf();
        $file = __DIR__ . '/../../Views/relatorio/venda/PdfDeUmaVenda.php';
        define("DOMPDF_ENABLE_PHP", true);
        $dompdf->set_option('chroot', $file);
        ob_start();
        include($file);
        $file = ob_get_clean();
        $dompdf->load_html($file);
        $dompdf->render(); #download

        // renderiza no navegador
        return $dompdf->stream('teste', array("Attachment" => false));
        // salva arquivo
        //return $dompdf->stream($this->nomeDoArquivo);
        exit(0);
    }
}
