<?php
namespace App\Controllers;

use App\Models\ProdutoCategoria;
use App\Rules\Logged;
use App\Services\UploadService\UploadFiles;
use Exception;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;

class CategoriaProdutoController extends Controller
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

        $this->post = new Post();
        $this->get = new Get();
        $this->idEmpresa = Session::get('idEmpresa');

        $logged = new Logged();
        $logged->isValid();
    }

    public function save()
    {
        try {
            $produtoCategoria = new ProdutoCategoria();
            $dados = (array) $this->post->data();

            $produtoCategoria->save($dados);

            return $this->get->redirectTo("produto");

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function modalIndex($idProduto)
    {
        $produto = false;

        if ($idProduto) {
            $produto = new Produto();
            $produto = $produto->find($idProduto);
        }

        $this->view('produto/categoria/index', null, compact('produto'));
    }

    public function modalFormulario($idProduto)
    {
        $produto = false;

        if ($idProduto) {
            $produto = new Produto();
            $produto = $produto->find($idProduto);
        }

        $this->view('produto/categoria/index', null, compact('produto'));
    }
}
