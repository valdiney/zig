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

        $this->diretorioImagemProdutoPadrao = 'public/imagem/produtos/';
        # Pega o diretório setado no .env
        $this->diretorioImagemProdutoNoEnv = getenv('DIRETORIO_IMAGENS_PRODUTO');

        $this->post = new Post();
        $this->get = new Get();
        $this->idEmpresa = Session::get('idEmpresa');

        $logged = new Logged();
        $logged->isValid();
    }

    public function index()
    {
        $produto = new Produto();
        $produtos = $produto->produtos($this->idEmpresa);

        $this->view('produto/index', $this->layout, compact('produtos'));
    }

    public function save()
    {
        if ($this->post->hasPost()) {
            $produto = new Produto();
            $dados = (array) $this->post->data();

            $dados['id_empresa'] = $this->idEmpresa;
            $dados['preco'] = formataValorMoedaParaGravacao($dados['preco']);

            if ( ! isset($dados['deleted_at'])) {
                $dados['deleted_at'] = timestamp();
            } else {
                # Retira o deleted_at do array para que seja cadastrado como null no banco
                unset($dados['deleted_at']);
            }

            # Valida imagem somente se existir no envio
            if (!empty($_FILES["imagem"]['name'])) {

                $diretorioImagem = false;
                if ($this->diretorioImagemProdutoNoEnv && !is_null($this->diretorioImagemProdutoNoEnv)) {
                    $diretorioImagem = $this->diretorioImagemProdutoNoEnv;
                } else {
                    $diretorioImagem = $this->diretorioImagemProdutoPadrao;
                }

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

                $dados['imagem'] = $retornoImagem;
            }

            try {
                $produto->save($dados);
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

            if ( ! isset($this->post->data()->deleted_at)) {
                $dados['deleted_at'] = timestamp();
            } else {
                # Retira o deleted_at do array para que seja cadastrado como null no banco
                unset($dados['deleted_at']);
            }

            $dados['preco'] = formataValorMoedaParaGravacao($dados['preco']);

            if (!empty($_FILES["imagem"]['name'])) {

                if (file_exists($dadosProduto->imagem)) {
                    # Deleta a imagem anterior
                    unlink($dadosProduto->imagem);
                }

                $diretorioImagem = false;
                if ($this->diretorioImagemProdutoNoEnv && !is_null($this->diretorioImagemProdutoNoEnv)) {
                    $diretorioImagem = $this->diretorioImagemProdutoNoEnv;
                } else {
                    $diretorioImagem = $this->diretorioImagemProdutoPadrao;
                }

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

                $dados['imagem'] = $retornoImagem;
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
}
