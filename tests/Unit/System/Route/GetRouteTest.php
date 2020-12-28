<?php

namespace Tests\Unit\System\Route;

use PHPUnit\Framework\TestCase;
use System\Route\GetRoute;

class GetRouteTest extends TestCase
{
    /** @var GetRoute */
    private $getRoute;

    /**
     * @dataProvider urls
     * @param bool $https
     * @param string|null $scriptName
     * @param string|null $host
     * @param string $expected
     */
    public function testSePegaAUrlCorreta(bool $https, string $scriptName, string $host, string $expected): void
    {
        $url = $this->getRoute->getBaseUrl($https, $scriptName, $host);

        self::assertEquals($expected, $url);
    }

    public function testSePegaControllerEMetodoCorreto(): void
    {
        $this->getRoute->generateControllerAndMethod("/public/index.php", "/users/1");

        $urlParameters = $this->getRoute->getUrlParameters();

        self::assertEquals(["users", "1"], $urlParameters);
    }

    public function urls(): array
    {
        return [
            [false, "/public/index.php", "localhost:8000", "http://localhost:8000"],
            [true, "/public/index.php", "tonie.com.br", "https://tonie.com.br"],
            [false, "/teste/public/index.php", "localhost", "http://localhost/teste"],
            [false, "/abc/def/ghi/public/index.php", "localhost", "http://localhost/abc/def/ghi"],
        ];
    }

    protected function setUp(): void
    {
        $this->getRoute = new GetRoute();
    }
}
