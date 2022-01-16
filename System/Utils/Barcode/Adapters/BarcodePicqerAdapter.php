<?php

namespace System\Utils\Barcode\Adapters;

use System\Utils\Barcode\Contracts\BarcodeAdapter;
use Picqer\Barcode\BarcodeGeneratorSVG;

class BarcodePicqerAdapter extends BarcodeAdapter
{
    public function __construct()
    {
        $this->generator = new BarcodeGeneratorSVG();
    }

    public function prepare(string $code): void
    {
        $code = $this->generator->getBarcode($code, BarcodeGeneratorSVG::TYPE_KIX);
        $this->code = $code;
    }
}
