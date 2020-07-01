<?php

namespace App\Controllers;
use System\Controller\Controller;
use System\Post\Post;
use System\Get\Get;

class _ClassName_ extends Controller
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
    $this->view('login/index', $this->layout);
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
