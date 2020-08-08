<?php
namespace App\Controllers\Api;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;

use App\Models\Usuario;

class TesteController extends Controller
{
	protected $post;
	protected $get;

	public function __construct()
	{
		parent::__construct();

		$this->post = new Post();
		$this->get = new Get();
	}

	public function vendedores()
	{
     $vendedor = new Usuario();
     echo json_encode($vendedor->all());
	}
}
