<?php

namespace App\Controllers\Api;

use App\Models\Usuario;
use App\Services\JwtService\JwtService;
use System\Controller\Controller;
use System\Get\Get;
use System\Post\Post;

class LoginController extends Controller
{
    protected $post;
    protected $get;

    public function __construct()
    {
        parent::__construct();

        $this->post = new Post();
        $this->get = new Get();
    }

    public function logar()
    {
        if ($this->post->hasPost()) {
            $email = $this->post->data()->email;
            $password = $this->post->data()->password;

            $usuario = new Usuario();
            $dadosUsuario = $usuario->findBy('email', $email);

            if ($usuario->userExist(['email' => $email, 'password' => $password])) {

                $jwtService = new JwtService();

                echo json_encode([
                    'token' => in64($jwtService->createJwt($dadosUsuario->id)),
                    'message' => 'Usuario logado',
                    'sucess' => true
                ]);

            } else {
                echo json_encode([[], 'message' => 'Usuario não encontrado', 'sucess' => false]);
            }
        }
    }

    public function logout()
    {

    }

    public function teste()
    {

    }
}
