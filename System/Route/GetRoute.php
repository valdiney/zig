<?php
namespace System\Route;

/*
|--------------------------------------------------------------------------
| GetRoute
|--------------------------------------------------------------------------
| This class is used to catch the route from url on browser.
|
*/

class GetRoute
{
  private $baseUrl;
  private $urlParamethers;
  private $controller;
  private $method;

  private $controllerNameAliases;
  private $methodNameAliases;

  public $existControllerOnRoute = false;
  public $existMethodOnRoute = false;

  public function __construct()
  {
    $this->baseUrl = $this->getBaseUrl();

    $this->getControllerAndMethod();
    $this->veriFyControllerOnUrl();
    $this->veriFyMethodOnUrl();

    if ( ! defined('CONTROLLER_NAME') && ! defined('BASEURL')) {
        define('CONTROLLER_NAME', $this->controller);
        define('METHOD_NAME', $this->method);
        define('BASEURL', $this->getBaseUrl());
    }

    $this->getUrlVariables();
  }

  public function getControllerNameAliases()
  {
    return $this->controllerNameAliases;
  }

  public function getMethodNameAliases()
  {
    return $this->methodNameAliases;
  }

    /**
    * This method is used to obtain and separate the
    * name of controller and the called method on url.
    */
  private function getControllerAndMethod()
  {
      $scriptName = dirname($_SERVER['SCRIPT_NAME'], 2);
      $redirectUrl = str_replace("{$scriptName}/", '', $_SERVER['REQUEST_URI']);
      $redirectUrl = trim($redirectUrl, '/');

      if ($redirectUrl) {
          $this->urlParamethers = explode('/', $redirectUrl);
      }
  }

    /**
    * This method is used to verify if exist controller name passed on url of the browser.
    */
  private function veriFyControllerOnUrl()
  {
    if ( ! empty($this->urlParamethers[3])) {
      $this->existControllerOnRoute = true;
    }
    if ($this->urlParamethers && array_key_exists(0, $this->urlParamethers)) {
      $this->controller = ucfirst($this->urlParamethers[0]).'Controller';
      $this->controllerNameAliases = $this->urlParamethers[0];
    }
  }

    /**
    * This method is used to verify if exist method name passed on url of the browser.
    */
  private function veriFyMethodOnUrl()
  {
    if ($this->urlParamethers && array_key_exists(1, $this->urlParamethers)) {
      $this->method = $this->urlParamethers[1];
      $nameAndAliases = $this->urlParamethers;
      array_shift($nameAndAliases);
      $nameAndAliases = implode('/', $nameAndAliases);
      $this->methodNameAliases = $nameAndAliases;
    }
  }

  public function getUrlVariables()
  {
      if ($this->urlParamethers == null) {
        return [];
      }

    $data = [];
    foreach ($this->urlParamethers as $key => $value) {
      if ($key >= 2) {
        array_push($data, $value);
      }
    }

    return $data;
  }

    /**
    * This method is return the controller name.
    * @return String
    */
  public function getControllerName()
  {
    return $this->controller;
  }

    /**
    * This method return the method name.
    * @return String
    */
  public function getMethodName()
  {
    return $this->method;
  }

    /**
    * This method return the url passed on browser.
    * Example http://localhost:8000
    * @return String
    */
  public function getBaseUrl()
  {
    $protocol = "http";
    if ( ! is_null(getenv('HTTPS'))) {
      if (getenv('HTTPS') == 'true') {
          $protocol = "https";
      }
        }

      $branch  = dirname($_SERVER['SCRIPT_NAME'], 2);
      $branch  = trim($branch, '/');
      $baseUrl = "{$protocol}://{$_SERVER['HTTP_HOST']}{$branch}";
      return $baseUrl;
  }
}
