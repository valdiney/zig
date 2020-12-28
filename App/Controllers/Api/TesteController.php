<?php

namespace App\Controllers\Api;

use App\Models\Usuario;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;

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
