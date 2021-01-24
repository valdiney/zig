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

    public function __construct(array $get, array $post = [], array $session = [])
    {
        $this->get = sanitizeMany($get);
        $this->post = sanitizeMany($post);
        $this->session = sanitizeMany($session);
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
}
