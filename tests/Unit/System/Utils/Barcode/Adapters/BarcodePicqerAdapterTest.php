<?php

namespace Test\Unit\System\Utils\Barcode\Adapters;

use PHPUnit\Framework\TestCase;
use System\Utils\Barcode\Adapters\BarcodePicqerAdapter;
use System\Utils\Barcode\Contracts\BarcodeAdapter;

class BarcodePicqerAdapterTest extends TestCase
{
    public function testGaranteQueOAdapterEhInstanciaDeBarcodeAdapter()
    {
        $adapter = new BarcodePicqerAdapter();

        $isInstanceOfBarcodeAdapter = is_a($adapter, BarcodeAdapter::class);

        $this->assertTrue($isInstanceOfBarcodeAdapter);
    }

    public function testGaranteQueAClassePodeGerarUmSvg()
    {
        $adapter = new BarcodePicqerAdapter();
        $adapter->prepare('Tonie');

        $svg = $adapter->toSvg();

        $this->assertContains('<svg', $svg);
    }
}
