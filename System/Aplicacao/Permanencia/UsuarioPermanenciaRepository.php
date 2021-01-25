<?php

namespace System\Aplicacao\Permanencia;

use System\Entidade\EntidadeUsuario;

interface UsuarioPermanenciaRepository
{
    /**
     * @param EntidadeUsuario $usuario
     * @return void
     */
    public function adicionaPermanencia(EntidadeUsuario $usuario): void;

    /**
     * @param EntidadeUsuario $usuario
     * @return mixed
     */
    public function checaEstaConectado(EntidadeUsuario $usuario): bool;

    /**
     * @param EntidadeUsuario $usuario
     * @return mixed
     */
    public function removePermanencia(EntidadeUsuario $usuario): void;
}
