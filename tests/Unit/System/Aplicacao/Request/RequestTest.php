<?php

namespace Tests\Unit\System\Aplicacao\Request;

use PHPUnit\Framework\TestCase;
use System\Aplicacao\Request\Request;
use System\Entidade\EntidadeUsuario;
use System\Infra\Permanencia\UsuarioPermanenciaObjectRepo;

class RequestTest extends TestCase
{
    public function testSeEhCapazDeReceberGet(): void
    {
        $data = ["user" => 1];
        $request = new Request($data);
        $result = $request->get("user");
        self::assertEquals(1, $result);

        $data = ["data" => "lorem-ipsum"];
        $request = new Request($data);
        $result = $request->get("data");
        self::assertEquals("lorem-ipsum", $result);
    }

    public function testSeEhCapazDeReceberPost(): void
    {
        $data = ["user" => 1];
        $request = new Request([], $data);
        $result = $request->post("user");
        self::assertEquals(1, $result);

        $data = ["data" => "lorem-ipsum"];
        $request = new Request([], $data);
        $result = $request->post("data");
        self::assertEquals("lorem-ipsum", $result);
    }

    public function testSeEhCapazDeReceberSession(): void
    {
        $_SESSION["teste"] = 123;
        $request = new Request([], [], $_SESSION);
        $result = $request->session("teste");
        self::assertEquals(123, $result);

        $_SESSION["lorem"] = "ipsum";
        $request = new Request([], [], $_SESSION);
        $result = $request->session("lorem");
        self::assertEquals("ipsum", $result);
    }

    public function testSeRecebeDadosDefaults(): void
    {
        $request = new Request();
        $request->setDefaults();

        $result = $request->get("teste");
        self::assertEquals("123", $result);
    }

    public function testSeRetornaQuandoOUsuarioEstaDesconectado(): void
    {
        $request = new Request();
        $result = $request->usuarioConectado();
        self::assertFalse($result);
    }

    public function testSeRetornaQuandoOUsuarioEstaConectado(): void
    {
        $usuario = new EntidadeUsuario(1);
        $permanencia = new UsuarioPermanenciaObjectRepo();
        $permanencia->adicionaPermanencia($usuario);

        $request = new Request();
        $request->setUsuario($usuario, $permanencia);
        $result = $request->usuarioConectado();
        self::assertTrue($result);
    }
}
