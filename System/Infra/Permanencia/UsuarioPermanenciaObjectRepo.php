<?php

namespace System\Infra\Permanencia;

use System\Aplicacao\Permanencia\UsuarioPermanenciaRepository;
use System\Entidade\EntidadeUsuario;

class UsuarioPermanenciaObjectRepo implements UsuarioPermanenciaRepository
{
    /** @var int|null */
    private $usuarioAtivo;

    public function adicionaPermanencia(EntidadeUsuario $usuario): void
    {
        $this->usuarioAtivo = $usuario->id();
    }

    public function checaEstaConectado(EntidadeUsuario $usuario): bool
    {
        return $this->usuarioAtivo === $usuario->id();
    }

    public function removePermanencia(EntidadeUsuario $usuario): void
    {
        $this->usuarioAtivo = null;
    }
}
