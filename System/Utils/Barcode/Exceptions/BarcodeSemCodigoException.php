<?php

namespace System\Utils\Barcode\Exceptions;

use Exception;

class BarcodeSemCodigoException extends Exception
{
    public function __construct()
    {
        $message = 'Ops! Parece que você não passou um código para gerar o barcode!';
        parent::__construct($message);
    }
}
