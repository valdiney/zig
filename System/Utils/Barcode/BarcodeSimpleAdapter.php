<?php

namespace System\Utils\Barcode;

class BarcodeSimpleAdapter extends BarcodeAdapter
{
    /** string */
    protected $code;

    public function prepare(string $code): void
    {
        $this->code = $code;
    }
}
