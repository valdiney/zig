<?php

if (!function_exists('generateRandomCodigoDeBarras')){
    function generateRandomCodigoDeBarras($prefix = null, $posfix = null): string
    {
        return $prefix . random_int(111111111111, 999999999999) . $posfix;
    }
}
