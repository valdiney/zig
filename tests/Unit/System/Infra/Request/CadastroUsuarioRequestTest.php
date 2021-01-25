<?php

namespace Tests\Unit\System\Infra\Request;

use InvalidArgumentException;
use System\Aplicacao\Request\Request;
use System\Infra\Request\CadastroExemploRequest;
use PHPUnit\Framework\TestCase;

class CadastroUsuarioRequestTest extends TestCase
{
    public function testSeMostraAcessoComoAutorizado(): void
    {
        $request = new Request([
            "role_id" => 1,
        ]);
        $cadastroRequest = new CadastroExemploRequest($request);

        $result = $cadastroRequest->acessoAutorizado();
        self::assertTrue($result);
    }

    public function testSeMostraAcessoNegado(): void
    {
        $request = new Request([
            "role_id" => 2,
        ]);
        $cadastroRequest = new CadastroExemploRequest($request);

        $result = $cadastroRequest->acessoAutorizado();
        self::assertFalse($result);
    }

    public function testSeExibeThrowQuandoOsCamposNaoSaoPassados(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $request = new Request();
        new CadastroExemploRequest($request);
    }

    public function testSeRetornaSomenteValoresEspecificados(): void
    {
        $request = new Request([
            "role_id" => 2,
            "outro_valor" => "lorem ipsum"
        ]);
        $cadastroRequest = new CadastroExemploRequest($request);

        $result = $cadastroRequest->all();
        self::assertEquals((object)["role_id" => 2], $result);
    }
}
