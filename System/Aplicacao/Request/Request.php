<?php

namespace System\Aplicacao\Request;

class Request
{
    /** @var array */
    private $get;
    /** @var array */
    private $post;
    /** @var array */
    private $session;

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
        return $this->get[$name] ?? null;
    }

    public function post(string $name = null)
    {
        if (!$name) {
            return $this->post;
        }
        return $this->post[$name] ?? null;
    }

    /**
     * Retorna $_GET e $_POST
     * @return array
     */
    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function session(string $name = null)
    {
        if (!$name) {
            return $this->session;
        }
        return $this->session[$name] ?? null;
    }

    /**
     * @param array $get
     */
    private function setGet(array $get): void
    {
        $this->get = sanitizeMany($get);
    }

    /**
     * @param array $post
     */
    private function setPost(array $post): void
    {
        $this->post = sanitizeMany($post);
    }

    /**
     * @param array $session
     */
    private function setSession(array $session = []): void
    {
        $this->session = sanitizeMany($session);
    }
}
