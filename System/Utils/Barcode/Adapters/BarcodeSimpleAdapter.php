<?php

namespace System\Utils\Barcode\Adapters;

use System\Utils\Barcode\Contracts\BarcodeAdapter;
use System\Utils\Barcode\Contracts\HasSvg;

class BarcodeSimpleAdapter extends BarcodeAdapter implements HasSvg
{
    /** string */
    protected $code;

    public function prepare(string $code): void
    {
        $this->code = $code;
    }

    public function toSvg(): string
    {
        return '';
    }
}
