<?php
namespace System\Session;

class Session
{
	public static function start()
  {
		if ( ! isset($_SESSION)) {
			session_start();
    }
    if (empty($_SESSION['session_code']) || time() - $_SESSION['session_time'] > 3600) {
      self::regenerate();
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

  public static function regenerate()
  {
    session_destroy();
    ini_set('session.use_strict_mode', 0);
    ini_set('session.cookie_lifetime', 103200);
    ini_set('session.cache_expire', 103200);
    ini_set('session.gc_maxlifetime', 103200);
    session_start();
    $sessionId = md5(uniqid(true).time());
    $_SESSION['session_code'] = $sessionId;
    $_SESSION['session_time'] = time();
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
    self::regenerate();
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
}
