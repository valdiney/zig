<?php

namespace System\Aplicacao\Request;

use stdClass;
use System\Aplicacao\Permanencia\UsuarioPermanenciaRepository;
use System\Entidade\EntidadeUsuario;

class Request
{
    /** @var array */
    private $get;
    /** @var array */
    private $post;
    /** @var array */
    private $session;
    /** @var UsuarioPermanenciaRepository */
    private $permanenciaRepository;
    /** @var EntidadeUsuario */
    private $entidadeUsuario;

    public function __construct(array $get = [], array $post = [], array $session = [])
    {
        $this->setGet($get);
        $this->setPost($post);
        $this->setSession($session);
    }

    public function setDefaults(): void
    {
        $this->setGet($_GET);
        $this->setPost($_POST);
        $this->setSession($_SESSION ?? []);
    }

    public function get(string $name = null)
    {
        if (!$name) {
            return $this->get;
        }
        return $this->get->{$name} ?? null;
    }

    public function post(string $name = null)
    {
        if (!$name) {
            return $this->post;
        }
        return $this->post->{$name} ?? null;
    }

    public function session(string $name = null)
    {
        if (!$name) {
            return $this->session;
        }
        return $this->session->{$name} ?? null;
    }

    /**
     * Retorna $_GET e $_POST
     * @return stdClass
     */
    public function all(): stdClass
    {
        return (object) array_merge((array) $this->get, (array) $this->post);
    }

    public function usuarioConectado(): bool
    {
        if (!$this->entidadeUsuario) {
            return false;
        }
        return $this->permanenciaRepository->checaEstaConectado($this->entidadeUsuario);
    }

    /**
     * @param array $get
     */
    public function setGet(array $get): void
    {
        $this->get = (object) sanitizeMany($get);
    }

    /**
     * @param array $post
     */
    public function setPost(array $post): void
    {
        $this->post = (object) sanitizeMany($post);
    }

    /**
     * @param array $session
     */
    public function setSession(array $session = []): void
    {
        $this->session = (object) sanitizeMany($session);
    }

    /**
     * @param EntidadeUsuario $usuario
     * @param UsuarioPermanenciaRepository $permanencia
     */
    public function setUsuario(EntidadeUsuario $usuario, UsuarioPermanenciaRepository $permanencia): void
    {
        $this->entidadeUsuario = $usuario;
        $this->permanenciaRepository = $permanencia;
    }
}
