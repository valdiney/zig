<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;
use App\Rules\Logged;

use App\Models\Produto;

use App\Services\UploadService\UploadFiles;

class ProdutoController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;
	protected $idEmpresa;

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

			$retornoImagem = uploadImageHelper(
				new UploadFiles(), 
				'public/imagem/produtos/', 
				$_FILES["imagem"]
			);

			# Verifica de houve erro durante o upload de imagem
			if (is_array($retornoImagem)) {
				Session::flash('error', $retornoImagem['error']);
				return $this->get->redirectTo("produto");
			}
            
		    $dados['imagem'] = $retornoImagem;

			try {
				$produto->save($dados);
				return $this->get->redirectTo("produto");

			} catch(\Exception $e) { 
    		    dd($e->getMessage());
    	    }
		}
	}

	public function update()
	{
		if ($this->post->hasPost()) {
			$produto = new Produto();
			$dadosProduto = $produto->find($this->post->data()->id);

			$dados = (array) $this->post->only([
				'nome', 'preco', 'descricao'
			]);

			$dados['preco'] = formataValorMoedaParaGravacao($dados['preco']);

			if ( ! empty($_FILES["imagem"]['name'])) {
                
                if (file_exists($dadosProduto->imagem) {
                	# Deleta a imagem anterior
				    unlink($dadosProduto->imagem);
                }
                
				$retornoImagem = uploadImageHelper(
					new UploadFiles(), 
					'public/imagem/produtos/', 
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

			} catch(\Exception $e) { 
    		    dd($e->getMessage());
    	    }
		}
	}

	public function modalFormulario()
	{
		$produto = false;
		
		if ($this->get->position(0)) {
        	$produto = new Produto();
		    $produto = $produto->find($this->get->position(0));
        }

		$this->view('produto/formulario', null, compact('produto'));
	}
}
