<?php

namespace Tests\Unit\System\Infra\Permanencia;

use System\Entidade\EntidadeUsuario;
use System\Infra\Permanencia\UsuarioPermanenciaObjectRepo;
use PHPUnit\Framework\TestCase;

class UsuarioPermanenciaObjectRepoTest extends TestCase
{
    public function testAdicionaPermanencia(): void
    {
        $usuario = new EntidadeUsuario(1);
        $repo = new UsuarioPermanenciaObjectRepo();
        $repo->adicionaPermanencia($usuario);

        $result = $repo->checaEstaConectado($usuario);
        self::assertTrue($result);
    }

    public function testRemovePermanencia(): void
    {
        $usuario = new EntidadeUsuario(1);
        $repo = new UsuarioPermanenciaObjectRepo();
        $repo->adicionaPermanencia($usuario);

        $repo->removePermanencia($usuario);

        $result = $repo->checaEstaConectado($usuario);
        self::assertFalse($result);
    }
}
