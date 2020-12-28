<?php

namespace System\Session;

class Token
{

    public static function verify()
    {
        /**
         * Caso o método seja GET,
         * gera um novo token e não verifica
         */
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!isset($_SESSION['_token'])) {
                self::generate();
            }
            define('TOKEN', $_SESSION['_token']);
            return;
        }
        /**
         * O método pode ser POST, PUT, DELETE...
         * ele verifica se foi passado token
         */
        if (!isset($_POST['_token']) && !isset($_SESSION['_token'])) {
            dd("Falta parâmetro _token!");
            return;
        }
        /**
         * Se o token não foi válido ele para a exibição
         */
        if (hash_equals($_POST['_token'], $_SESSION['_token']) === false) {
            dd("Token inválido!");
            return;
        }
        //
        // self::reGenerate();
    }

    public static function generate()
    {
        if (!isset($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
    }

    /**
     * Apaga o token atual e gera um novo
     */
    public static function reGenerate()
    {
        unset($_SESSION['_token']);
        self::generate();
    }

}
