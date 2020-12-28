<?php

namespace App\Controllers;

use App\Config\ConfigPerfil;
use App\Models\ClienteSegmento;
use App\Models\ConfigPdv;
use App\Models\Empresa;
use App\Models\Usuario;
use App\Rules\Logged;
use App\Rules\UsuarioPermissaoRule;
use Exception;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;

class EmpresaController extends Controller
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
        $empresa = new Empresa();
        $empresas = $empresa->all();

        $this->view('empresa/index', $this->layout, compact("empresas"));
    }

    public function save()
    {
        if ($this->post->hasPost()) {
            $empresa = new Empresa();
            $dados = (array)$this->post->data();

            try {
                $empresa->save($dados);

                # Cadastra um tipo de PDV para a Empresa
                $configPdv = new ConfigPdv();
                $configPdv->save([
                    'id_empresa' => $empresa->lastId(),
                    'id_tipo_pdv' => 1
                ]);

                # Cadastra um Usuário para empresa
                $usuario = new Usuario();
                $usuario->save([
                    'id_empresa' => $empresa->lastId(),
                    'nome' => $dados['nome'],
                    'email' => $dados['email'],
                    'password' => createHash('33473347'),
                    'id_sexo' => 1,
                    'id_perfil' => ConfigPerfil::adiministrador()
                ]);

                return $this->get->redirectTo("empresa");

            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
    }

    public function update()
    {
        if ($this->post->hasPost()) {

            $empresa = new Empresa();
            $dados = (array)$this->post->only([
                'nome', 'email', 'telefone', 'celular',
                'id_segmento'
            ]);

            try {
                $empresa->update($dados, $this->post->data()->id);
                return $this->get->redirectTo("empresa");

            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
    }

    public function verificaSeEmailExiste($email, $idEmpresa = false)
    {
        $email = out64($email);
        $empresa = new Empresa();

        /*
        * Se for uma edição,
        * verifica se o EMAIL não pertence a empresa que está sendo editado no momento
        */
        if ($email && $idEmpresa) {
            if ($empresa->seDadoNaoPertenceAEmpresaEditado('email', $email, $idEmpresa)) {
                echo json_encode(['status' => true]);
                return false;
            }
        }

        if ($empresa->verificaSeEmailExiste($email)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function modalFormulario($idEmpresa)
    {
        $empresa = false;

        if ($idEmpresa) {
            $empresa = new Empresa();
            $empresa = $empresa->find($idEmpresa);
        }

        $segmento = new ClienteSegmento();
        $segmentos = $segmento->all();

        $this->view('empresa/formulario', null,
            compact(
                'empresa',
                'segmentos'
            ));
    }
}
