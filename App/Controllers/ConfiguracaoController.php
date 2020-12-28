<?php

namespace App\Controllers;

use App\Models\ConfigPdv;
use App\Models\TipoPdv;
use App\Rules\Logged;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;

class ConfiguracaoController extends Controller
{
    protected $post;
    protected $get;
    protected $layout;
    protected $idEmpresa;
    protected $idUsuario;
    protected $idPerfilUsuarioLogado;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'default';

        $this->post = new Post();
        $this->get = new Get();
        $this->idEmpresa = Session::get('idEmpresa');
        $this->idUsuario = Session::get('idUsuario');
        $this->idPerfilUsuarioLogado = Session::get('idPerfil');

        $logged = new Logged();
        $logged->isValid();
    }

    public function index()
    {
        $tipoPdv = new TipoPdv();
        $tiposPdv = $tipoPdv->tiposPdv();

        $configPdv = new ConfigPdv();
        $configPdv = $configPdv->ConfigPdv($this->idEmpresa);

        $this->view('configuracao/index', $this->layout,
            compact(
                'tiposPdv',
                'configPdv'
            ));
    }

    public function alterarConfigPdv()
    {
        if ($this->post->hasPost()) {

            $idConfigPdv = $this->post->data()->idConfigPdv;
            $idTipoPdv = $this->post->data()->idTipoPdv;

            $configPdv = new ConfigPdv();
            $dadosConfigPdv = $configPdv->find($idConfigPdv);
            $dados['id_tipo_pdv'] = $idTipoPdv;

            try {
                $configPdv->update($dados, $dadosConfigPdv->id);
                echo json_encode(['status' => true]);

            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }
    }
}

