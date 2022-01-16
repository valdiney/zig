<?php

namespace System\Utils\Barcode;

use System\Utils\Barcode\Contracts\BarcodeAdapter;

class BarcodeSimpleAdapter extends BarcodeAdapter
{
    /** string */
    protected $code;

    public function prepare(string $code): void
    {
        $this->code = $code;
    }
}
