<?php 
namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;

class HomeController extends Controller
{
	protected $post;
	protected $get;
	protected $layout;
	
	public function __construct()
	{
		parent::__construct();
		$this->layout = 'teste';

		$this->post = new Post();
		$this->get = new Get();
	}

	public function index()
	{
		$this->view('home/index', $this->layout);
	}

	public function hello()
	{
		$this->view('home/hello', $this->layout);
	}
}