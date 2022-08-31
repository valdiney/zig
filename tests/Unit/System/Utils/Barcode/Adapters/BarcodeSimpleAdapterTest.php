<?php

namespace Tests\Unit\System\Utils\Barcode\Adapters;

use PHPUnit\Framework\TestCase;
use System\Utils\Barcode\Adapters\BarcodeSimpleAdapter;
use System\Utils\Barcode\Contracts\BarcodeAdapter;

class BarcodeSimpleAdapterTest extends TestCase
{
    public function testGaranteQueOAdapterEhInstanciaDeBarcodeAdapter()
    {
        $adapter = new BarcodeSimpleAdapter();

        $isInstanceOfBarcodeAdapter = is_a($adapter, BarcodeAdapter::class);

        $this->assertTrue($isInstanceOfBarcodeAdapter);
    }

    public function testPodeRetornarOCodeComoAMesmaString(): void
    {
        $adapter = new BarcodeSimpleAdapter();

        $adapter->prepare('123');
        $result = $adapter->getCode();

        $this->assertEquals($result, '123');
    }
}
