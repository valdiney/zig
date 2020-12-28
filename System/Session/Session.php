<?php

namespace System\Session;

use App\Services\LoginRemeber\LoginRemeber;

class Session
{
    public static function start()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public static function set($name = null, $value = null)
    {
        $_SESSION[$name] = $value;
    }

    public static function get($name = null)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return false;
    }

    public static function hasSession($name = null)
    {
        if (isset($_SESSION[$name])) {
            return true;
        }

        return false;
    }

    public static function logout()
    {
        Session::unset('logged');

        self::handleRemoveLoginCookie();
    }

    public static function unset($name)
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
            return true;
        }

        return false;
    }

    /**
     * --------------------------------------------------------------------------
     * Methods about flash message
     * --------------------------------------------------------------------------
     */
    public static function flash($name = null, $value = null)
    {
        $key = 'flash_' . $name;
        $_SESSION[$key] = $value;
    }

    public static function hasFlash($name = null)
    {
        $name = 'flash_' . $name;
        if (isset($_SESSION[$name])) {
            return true;
        }

        return false;
    }

    public static function getFlash($name = null)
    {
        $name = 'flash_' . $name;
        return $_SESSION[$name];
    }

    private static function handleRemoveLoginCookie()
    {
        $loginRemember = new LoginRemeber();
        $cookieName = $loginRemember->getCookieName();
        Session::unset($cookieName);
    }
}
