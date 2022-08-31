<?php

namespace System\Utils\Barcode\Contracts;

use System\Utils\Barcode\Exceptions\BarcodeSemCodigoException;

interface HasSvg
{
    /**
     * @throws BarcodeSemCodigoException
     */
    public function toSvg(): string;
}
