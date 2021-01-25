<?php

namespace System\Entidade;

class EntidadeUsuario
{
    /** @var int */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }
}
