<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Models\ClienteSegmento;
use App\Models\ClienteTipo;
use App\Rules\Logged;
use Exception;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;
use System\Session\Session;

class ClienteController extends Controller
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
        $cliente = new Cliente();
        $clientes = $cliente->clientes($this->idEmpresa);

        $this->view('cliente/index', $this->layout, compact("clientes"));
    }

    public function save()
    {
        if ($this->post->hasPost()) {
            $cliente = new Cliente();
            $dados = (array)$this->post->data();
            $dados['id_empresa'] = $this->idEmpresa;

            try {
                $cliente->save($dados);
                return $this->get->redirectTo("cliente");

            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
    }

    public function update()
    {
        $cliente = new Cliente();
        $dadosCliente = $cliente->find($this->post->data()->id);
        $dados = (array)$this->post->only([
            'id_cliente_tipo', 'id_cliente_segmento',
            'nome', 'email', 'cnpj', 'cpf', 'telefone', 'celular'
        ]);

        $dados['id_empresa'] = $this->idEmpresa;

        try {
            $cliente->update($dados, $dadosCliente->id);
            return $this->get->redirectTo("cliente");

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function modalFormulario($idCliente = false)
    {
        $cliente = false;

        if ($idCliente) {
            $cliente = new Cliente();
            $cliente = $cliente->find($idCliente);
        }

        $clienteTipo = new ClienteTipo();
        $clientesTipos = $clienteTipo->all();

        $clienteSegmento = new ClienteSegmento();
        $clientesSegmentos = $clienteSegmento->segmentos();

        $this->view('cliente/formulario', null,
            compact(
                'cliente',
                'clientesTipos',
                'clientesSegmentos'
            ));
    }

    public function verificaSeEmailExiste($email, $idCliente = false)
    {
        $email = out64($email);
        $cliente = new Cliente();

        /*
    * Se for uma edição,
    * verifica se o EMAIL não pertence ao cliente que está sendo editado no momento
    */
        if ($idCliente && $email) {
            if ($cliente->seDadoNaoPertenceAoClienteEditado('email', $email, $idCliente)) {
                echo json_encode(['status' => true]);
                return false;
            }
        }

        if ($cliente->verificaSeEmailExiste($email)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function verificaSeCnpjExiste($cnpj, $idCliente = false)
    {
        $cnpj = out64($cnpj);
        $cliente = new Cliente();

        /*
        * Se for uma edição,
        * verifica se o CNPJ não pertence ao cliente que está sendo editado no momento
        */
        if ($idCliente && $cnpj) {
            if ($cliente->seDadoNaoPertenceAoClienteEditado('cnpj', $cnpj, $idCliente)) {
                echo json_encode(['status' => true]);
                return false;
            }
        }

        if ($cliente->verificaSeCnpjExiste($cnpj)) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function verificaSeCpfExiste($cpf, $idCliente = false)
    {
        $cpf = out64($cpf);
        $cliente = new Cliente();

        /*
    * Se for uma edição,
    * verifica se o CPF não pertence ao cliente que está sendo editado no momento
    */
        if ($idCliente && $cpf) {
            if ($cliente->seDadoNaoPertenceAoClienteEditado('cpf', $cpf, $idCliente)) {
                echo json_encode(['status' => true]);
                return false;
            }
        }

        if ($cliente->verificaSeCpfExiste(out64($cpf))) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    function desativarCliente($idCliente)
    {
        $cliente = new Cliente();
        $dados['deleted_at'] = date('Y-m-d H:i:s');

        try {
            $cliente->update($dados, $idCliente);
            echo json_encode(['status' => true]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    function ativarCliente($idCliente)
    {
        $cliente = new Cliente();
        $dados['deleted_at'] = null;

        try {
            $cliente->update($dados, $idCliente);
            echo json_encode(['status' => true]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
