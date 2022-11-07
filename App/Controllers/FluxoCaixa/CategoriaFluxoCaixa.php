<?php
namespace App\Controllers\FluxoCaixa;

use App\Rules\Logged;
use Exception;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;
use App\Models\FluxoCaixa;

class CategoriaFluxoCaixa extends Controller
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

    public function modalCategoria($idCategoria = false)
    {

    }
}
