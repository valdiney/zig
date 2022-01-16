<?php

namespace Test\Unit\System\Infra\Barcode\Contracts;

use PHPUnit\Framework\TestCase;
use System\Utils\Barcode\Adapters\BarcodeSimpleAdapter;
use System\Utils\Barcode\Contracts\HasSvg;

class HasSvgTest extends TestCase
{
    public function testBarcodeSimpleEhInstanciaDeSvg()
    {
        $adapter = new BarcodeSimpleAdapter();

        $isInstance = is_a($adapter, HasSvg::class);

        $this->assertTrue($isInstance);
    }
}
