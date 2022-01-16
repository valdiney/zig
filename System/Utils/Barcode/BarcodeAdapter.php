<?php

namespace System\Utils\Barcode;

abstract class BarcodeAdapter
{
    public abstract function prepare(string $code): void;

    public function getCode(): string
    {
        return $this->code;
    }
}
