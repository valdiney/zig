<?php

namespace System\Utils\Barcode\Adapters;

use System\Utils\Barcode\Contracts\BarcodeAdapter;
use Picqer\Barcode\BarcodeGeneratorSVG;
use System\Utils\Barcode\Contracts\HasSvg;
use System\Utils\Barcode\Exceptions\BarcodeSemCodigoException;

class BarcodePicqerAdapter extends BarcodeAdapter implements HasSvg
{
    public function prepare(string $code): void
    {
        $this->code = $code;
    }

    public function toSvg(): string
    {
        if (empty($this->code)) {
            throw new BarcodeSemCodigoException();
        }
        $generator = new BarcodeGeneratorSVG();
        return $generator->getBarcode($this->code, BarcodeGeneratorSVG::TYPE_CODE_128);
    }
}
