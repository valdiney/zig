<?php

if (!function_exists('generateRandomCodigoDeBarras')){
    function generateRandomCodigoDeBarras($prefix = null, $posfix = null): string
    {
        return $prefix . date('Y') . $posfix;
    }
}
