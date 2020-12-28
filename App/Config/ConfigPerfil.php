<?php

namespace App\Config;

class ConfigPerfil
{
    # Estes valores devem ser os mesmos do banco de dados
    public static function superAdmin()
    {
        return 1;
    }

    public static function adiministrador()
    {
        return 2;
    }

    public static function gerente()
    {
        return 5;
    }

    public static function vendedor()
    {
        return 4;
    }
}
