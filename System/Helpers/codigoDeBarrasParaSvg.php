<?php

use System\Utils\Barcode\Adapters\BarcodePicqerAdapter;

if (!function_exists('codigoDeBarrasParaSvg')){
    function codigoDeBarrasParaSvg(string $codigo, string $adapter = null): string
    {
        $adapter = $adapter ?? BarcodePicqerAdapter::class;
        if (is_a('HasSvg', $adapter) === false) {
            throw new \InvalidArgumentException(sprintf(
                'Ops! A classe %s não possui a funcionalidade de gerar svg!',
                $adapter
            ));
        }
        $adapter = new $adapter();
        $adapter->prepare($codigo);
        return $adapter->toSvg();
    }
}
