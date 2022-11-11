<?php
namespace App\Controllers;

use App\Models\Produto;
use App\Rules\Logged;
use App\Services\UploadService\UploadFiles;
use Exception;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

class ProdutoController extends Controller
{
    protected $post;
    protected $get;
    protected $layout;
    protected $idEmpresa;
    protected $diretorioImagemProdutoNoEnv;
    protected $diretorioImagemProdutoPadrao;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'default';

        $path = filter_var(getenv('SHARED_HOST'), FILTER_VALIDATE_BOOLEAN) ? 'imagem/produtos/' : 'public/imagem/produtos/';
        $this->diretorioImagemProdutoPadrao = $path;

        $this->post = new Post();
        $this->get = new Get();
        $this->idEmpresa = Session::get('idEmpresa');

        $logged = new Logged();
        $logged->isValid();
    }

    public function index()
    {
        $produto = new Produto();
        $informacoes = $produto->informacaoesGeraisDosProdutos($this->idEmpresa);

        $this->view('produto/index', $this->layout,compact('informacoes'));
    }

    public function save()
    {
        if ($this->post->hasPost()) {
            $produto = new Produto();
            $dados = (array) $this->post->data();

            $dados['id_empresa'] = $this->idEmpresa;
            $dados['preco'] = formataValorMoedaParaGravacao($dados['preco']);

            if (isset($dados['mostrar_em_vendas'])) {
                $dados['mostrar_em_vendas'] = 1;
            } else {
                $dados['mostrar_em_vendas'] = 0;
            }

            if (isset($dados['ativar_quantidade'])) {
                $dados['ativar_quantidade'] = 1;
            }

            # Valida imagem somente se existir no envio
            if (!empty($_FILES["imagem"]['name'])) {
                $diretorioImagem = $this->diretorioImagemProdutoPadrao;
                $retornoImagem = uploadImageHelper(
                    new UploadFiles(),
                    $diretorioImagem,
                    $_FILES["imagem"]
                );

                # Verifica de houve erro durante o upload de imagem
                if (is_array($retornoImagem)) {
                    Session::flash('error', $retornoImagem['error']);
                    return $this->get->redirectTo("produto");
                }

                $dados['imagem'] = filter_var(getenv('SHARED_HOST'), FILTER_VALIDATE_BOOLEAN) ? "public/{$retornoImagem}" : $retornoImagem;
            }

            try {
                $idProduto = $produto->save($dados);

                # adiciona codigo de barras se nao existir
                if (empty($dados['codigo'])) {
                    $codigoDeBarras = generateRandomCodigoDeBarras($idProduto);
                    $produto = new Produto();
                    $produto->update(['codigo' => $codigoDeBarras], $idProduto);
                }

                $produto = $produto->getBy($this->idEmpresa, $idProduto);

                return $this->get->redirectTo("produto");

            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
    }

    public function update()
    {
        if ($this->post->hasPost()) {
            $produto = new Produto();
            $dadosProduto = $produto->find($this->post->data()->id);

            $dados = (array)$this->post->only([
                'nome', 'preco', 'descricao'
            ]);

            $dados['descricao'] = nl2br($dados['descricao']);

            if (isset($this->post->data()->mostrar_em_vendas)) {
                $dados['mostrar_em_vendas'] = 1;
            } else {
                $dados['mostrar_em_vendas'] = 0;
            }

            # Trata quantidade
            $dados['ativar_quantidade'] = isset($this->post->data()->ativar_quantidade) ? 1 : 0;
            $dados['quantidade'] = isset($this->post->data()->quantidade) ? $this->post->data()->quantidade : $dadosProduto->quantidade;

            $dados['preco'] = formataValorMoedaParaGravacao($dados['preco']);

            if (!empty($_FILES["imagem"]['name'])) {

                if (file_exists($dadosProduto->imagem)) {
                    # Deleta a imagem anterior
                    unlink($dadosProduto->imagem);
                }

                $diretorioImagem = $this->diretorioImagemProdutoPadrao;
                $retornoImagem = uploadImageHelper(
                    new UploadFiles(),
                    $diretorioImagem,
                    $_FILES["imagem"]
                );

                # Verifica de houve erro durante o upload de imagem
                if (is_array($retornoImagem)) {
                    Session::flash('error', $retornoImagem['error']);
                    return $this->get->redirectTo("produto");
                }

                $dados['imagem'] = filter_var(getenv('SHARED_HOST'), FILTER_VALIDATE_BOOLEAN) ? "public/{$retornoImagem}" : $retornoImagem;
            }

            try {
                $produto->update($dados, $dadosProduto->id);
                return $this->get->redirectTo("produto");

            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
    }

    public function modalFormulario($idProduto)
    {
        $produto = false;

        if ($idProduto) {
            $produto = new Produto();
            $produto = $produto->find($idProduto);
        }

        $this->view('produto/formulario', null, compact('produto'));
    }

    public function pesquisarProdutoPorNome($nome = false)
    {
        $nome = utf8_encode(out64($nome));

        $produto = new Produto();
        $produtos = $produto->produtos($this->idEmpresa, $nome);

        $this->view('produto/produtos', null, compact('produtos','nome'));
    }

    public function pesquisarProdutoPorCodigoDeBarras(string $codigo = null)
    {
        $codigo = $codigo? utf8_encode(out64($codigo)): null;

        $produto = new Produto();
        $produtos = $produto->getBy($this->idEmpresa, 'codigo', $codigo);

        $nome = null;

        $this->view('produto/produtos', null, compact('produtos','nome','codigo'));
    }

    public function excluirProduto($idProduto)
    {
        $produto = new Produto();
        try {
            $produto->update(['deleted_at' => timestamp()], $idProduto);
            echo json_encode(['deletado' => true]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
