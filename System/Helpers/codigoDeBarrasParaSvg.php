<?php

use System\Utils\Barcode\Adapters\BarcodePicqerAdapter;
use System\Utils\Barcode\Contracts\HasSvg;

if (!function_exists('codigoDeBarrasParaSvg')){
    function codigoDeBarrasParaSvg(string $codigo = null, string $adapter = null): string
    {
        $adapter = $adapter ?? BarcodePicqerAdapter::class;
        $adapter = new $adapter();
        if (($adapter instanceof HasSvg) === false) {
            throw new \InvalidArgumentException(sprintf(
                'Ops! A classe %s não possui a funcionalidade de gerar svg!',
                $adapter
            ));
        }
        $adapter->prepare($codigo);
        return $adapter->toSvg();
    }
}
