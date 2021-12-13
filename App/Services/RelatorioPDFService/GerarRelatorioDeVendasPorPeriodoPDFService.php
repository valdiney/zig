<?php

namespace App\Services\RelatorioPDFService;

use Dompdf\Dompdf;

class GerarRelatorioDeVendasPorPeriodoPDFService
{
    protected $titulo;
    protected $nomeDoArquivo;
    protected $diretorio;
    protected $periodo = [];
    protected $empresa;
    protected $totalVendas;

    public function setTotalVendas($totalVendas)
    {
        $this->totalVendas = $totalVendas;
    }

    public function getTotalVendas()
    {
        return $this->totalVendas;
    }

    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setNomeDoArquivo($nomeDoArquivo)
    {
        $this->nomeDoArquivo = $nomeDoArquivo . '.pdf';
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
        $titulo = "Relatório de vendas por período. {$this->periodo['de']} à {$this->periodo['ate']}";
        $head = [
            '#',
            'Usuário',
            'Produto',
            'Preço',
            'QTD',
            'Total',
            'PAG',
            'Data'
        ];
        $dados = [];
        $i = 0;
        foreach ($vendas as $venda) {
            $i++;
            $dados[] = [
                $i,
                stringAbreviation(ucfirst($venda->nomeUsuario), 12, '...'),
                stringAbreviation(ucfirst($venda->produtoNome), 15, '...'),
                ($venda->preco != 0) ? 'R$ ' . number_format($venda->preco, 2, ',', '.') : 'Não consta',
                (!is_null($venda->quantidade)) ? $venda->quantidade : 'Não consta',
                'R$ ' . number_format($venda->valor, 2, ',', '.'),
                $venda->legenda,
                $venda->data . ' ' . $venda->hora
            ];
        }
        //
        $dompdf = new Dompdf();
        // $dompdf->setPaper('A4', 'landscape');
        $file = __DIR__ . '/../../Views/relatorio/relatorioPDF.php';
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
        //return $dompdf->stream($this->nomeDoArquivo, array("Attachment" => false));
        // salva arquivo
        return $dompdf->stream($this->nomeDoArquivo);
        exit(0);
    }
}
