<?php

namespace System\Utils;

class Sanitize
{
    public static function value($value)
    {
        return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}
