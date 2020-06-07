<?php
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;
use System\Session\Session;
use App\Rules\Logged;

class PedidoController extends Controller
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

		$logged = new Logged();
		$logged->isValid();
	}

	public function index()
	{
		$this->view('pedido/index', $this->layout);
	}

	public function save()
	{
		# Escreva aqui...
	}

	public function update()
	{
		# Escreva aqui...
	}
}

