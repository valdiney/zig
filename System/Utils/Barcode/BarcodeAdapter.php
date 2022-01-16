<?php

namespace System\Utils\Barcode;

abstract class BarcodeAdapter
{
    public abstract function prepare(string $code): void;

    public function __toString()
    {
        return $this->code;
    }
}
