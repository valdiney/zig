<?php 
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;

use App\Models\Venda;

class VendaController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;
	
	public function __construct()
	{
		parent::__construct();
		$this->layout = 'default';

		$this->post = new Post();
		$this->get = new Get();
	}

	public function index()
	{
		$venda = new Venda();
		$vendas = $venda->vendas();

		$this->view('usuario/index', $this->layout, compact('usuarios'));
	}

	public function save()
	{
		
	}

	public function update()
	{
		
	}
}