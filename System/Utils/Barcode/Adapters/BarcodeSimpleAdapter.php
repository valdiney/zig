<?php

namespace System\Utils\Barcode\Adapters;

use System\Utils\Barcode\Contracts\BarcodeAdapter;
use System\Utils\Barcode\Contracts\HasSvg;
use System\Utils\Barcode\Exceptions\BarcodeSemCodigoException;

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
        if (empty($this->code)) {
            throw new BarcodeSemCodigoException();
        }
        return '<svg height="100" width="100">
                    <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" />
                    Sorry, your browser does not support inline SVG.
                </svg>';
    }
}
