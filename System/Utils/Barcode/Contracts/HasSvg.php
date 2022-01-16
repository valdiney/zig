<?php

namespace System\Utils\Barcode\Contracts;

interface HasSvg
{
    public function toSvg(): string;
}
