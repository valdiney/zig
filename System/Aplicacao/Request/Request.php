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

    public function get(string $name)
    {
        return $this->get[$name] ?? null;
    }

    public function post(string $name)
    {
        return $this->post[$name] ?? null;
    }

    public function session(string $name)
    {
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
