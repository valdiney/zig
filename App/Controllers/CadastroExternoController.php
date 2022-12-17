<?php

namespace App\Controllers;

use App\Models\Perfil;
use App\Models\Sexo;
use App\Models\Usuario;
use App\Services\SendEmail\SendEmail;
use App\Services\UploadService\UploadFiles;
use Exception;
use System\Controller\Controller;
use System\Get\Get;
use System\HtmlComponents\SendEmailTemplate\SimpleTemplate;
use System\Post\Post;
use System\Session\Session;

class CadastroExternoController extends Controller
{
    protected $post;
    protected $get;
    protected $layout;
    protected $idEmpresa;
    protected $idUsuarioLogado;
    protected $idPerfilUsuarioLogado;

    protected $diretorioImagemUsuarioNoEnv;
    protected $diretorioImagemUsuarioPadrao;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'login';

        $this->post = new Post();
        $this->get = new Get();
        $this->idEmpresa = Session::get('idEmpresa');
        $this->idUsuarioLogado = Session::get('idUsuario');
        $this->idPerfilUsuarioLogado = session::get('idPerfil');

        $path = filter_var(getenv('SHARED_HOST'), FILTER_VALIDATE_BOOLEAN) ? 'imagem/perfil_usuarios/' : 'public/imagem/perfil_usuarios/';
        $this->diretorioImagemUsuarioPadrao = $path;
    }

    public function index()
    {
        $this->view('login/criarConta', $this->layout);

    }
}
