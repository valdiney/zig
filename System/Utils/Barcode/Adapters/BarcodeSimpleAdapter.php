<?php

namespace System\Utils\Barcode\Adapters;

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
