<?php

namespace App\Controllers\Api;

use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;

class InicioPwaController extends Controller
{
    protected $post;
    protected $get;

    public function __construct()
    {
        parent::__construct();

        $this->post = new Post();
        $this->get = new Get();
    }

    public function index()
    {
        $this->view('pwa/login/index', null);
    }

    public function pdv()
    {
        $this->view('pwa/pdv/index', null);
    }
}
