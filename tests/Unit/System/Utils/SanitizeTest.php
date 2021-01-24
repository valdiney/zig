<?php

namespace Tests\Unit\System\Utils;

use PHPUnit\Framework\TestCase;

class SanitizeTest extends TestCase
{
    public function testSePodeRemoverCaracteresEspeciais(): void
    {
        $result = sanitize('"teste');
        self::assertEquals('&#34;teste', $result);
    }
}
