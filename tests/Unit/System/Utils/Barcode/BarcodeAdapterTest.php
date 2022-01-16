<?php

namespace Tests\Unit\System\Utils\Barcode;

use PHPUnit\Framework\TestCase;
use System\Utils\Barcode\BarcodeAdapter;
use System\Utils\Barcode\BarcodeSimpleAdapter;

class BarcodeAdapterTest extends TestCase
{
    public function testPodeRetornarUmBarcode(): void
    {
        $adapter = new BarcodeSimpleAdapter();

        $adapter->prepare('123');
        $result = (string) $adapter;

        $this->assertEquals($result, '123');
    }

    public function testGaranteQueOAdapterEhInstanciaDeBarcodeAdapter()
    {
        $adapter = new BarcodeSimpleAdapter();

        $isInstanceOfBarcodeAdapter = is_a($adapter, BarcodeAdapter::class);

        $this->assertTrue($isInstanceOfBarcodeAdapter);
    }
}
